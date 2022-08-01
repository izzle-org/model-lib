<?php
namespace Izzle\Model;

use ArrayAccess;
use DateTime;
use DateTimeZone;
use Exception;
use InvalidArgumentException;
use Izzle\Model\Traits\ObjectToArrayAccess;
use function is_array;
use function is_string;
use Izzle\Model\Exceptions\UnserializeException;
use Izzle\Support\Str;
use JsonSerializable;
use Serializable;

abstract class Model implements JsonSerializable, Serializable, ArrayAccess
{
    use ObjectToArrayAccess;
    
    /**
     * @var PropertyCollection|null
     */
    private ?PropertyCollection $propertyCollection = null;
    
    /**
     * @var bool
     */
    public static bool $serializeWithSnakeKeys = true;
    
    /**
     * @var string - Can be set to null, to serialize DateTime to object
     */
    public static string $serializedDateTimeFormat = DateTime::RFC3339_EXTENDED;
    
    /**
     * @param array|null $data
     * @throws Exception
     */
    public function __construct(array $data = null)
    {
        $this->loadData($data);
    }
    
    /**
     * @return PropertyCollection
     */
    public function properties(): PropertyCollection
    {
        if ($this->propertyCollection === null) {
            $this->propertyCollection = $this->loadProperties();
        }
        
        return $this->propertyCollection;
    }
    
    /**
     * @param string $name
     * @return PropertyInfo|null
     */
    public function property(string $name): ?PropertyInfo
    {
        return $this->properties()->getProperty($name);
    }
    
    /**
     * @param mixed $value
     * @param PropertyInfo $property
     * @return mixed
     * @throws Exception
     */
    public function cast($value, PropertyInfo $property)
    {
        if ($value === null) {
            return $value;
        }
        
        if ($property->isNavigation()) {
            if ($value instanceof self) {
                return $value;
            }
            
            $class = $property->getType();
            return is_array($value) ? new $class($value) : new $class();
        }
        
        $cast = static function ($value, PropertyInfo $property) {
            switch ($property->getType()) {
                case 'boolean':
                case 'bool':
                    if ($value === 'Y' || $value === 'N') {
                        return $value === 'Y' ?: false;
                    }
                    
                    return (bool) $value;
                case 'integer':
                case 'int':
                    return (int) $value;
                case 'float':
                case 'double':
                    return (double) $value;
                case 'string':
                    return (string) $value;
                case DateTime::class:
                    return is_string($value) ? (new DateTime($value))->setTimezone(new DateTimeZone('UTC')) : $value;
                case 'mixed':
                    return $value;
            }
            
            return $value;
        };
        
        if (is_array($value) && !$property->isNavigation() && $property->isArray()) {
            foreach ($value as &$v) {
                if (!($v instanceof self)) {
                    $v = $cast($v, $property);
                }
            }
            
            return $value;
        }
        
        return $cast($value, $property);
    }
    
    /**
     * @return PropertyCollection
     */
    abstract protected function loadProperties(): PropertyCollection;
    
    /**
     * @inheritDoc
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }
    
    /**
     * @return array
     */
    public function __serialize(): array
    {
        return $this->toArray();
    }
    
    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function __unserialize(array $data): void
    {
        $this->loadData($data);
    }
    
    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }
    
    /**
     * @param string $data
     * @throws UnserializeException
     * @throws Exception
     */
    public function unserialize($data): void
    {
        $d = unserialize($data, [true]);
        if ($d === false) {
            throw new UnserializeException(sprintf('Could not unserialize data from %s', get_class($this)));
        }
    
        $this->loadData($d);
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this->properties() as $property) {
            /** @var PropertyInfo $property */
            if ($property->isHidden()) {
                continue;
            }
            
            if (!is_callable([$this, $property->getter()])) {
                continue;
            }
            
            $key = self::$serializeWithSnakeKeys ?
                Str::snake($property->getName()) :
                $property->getName();
    
            if ($property->isNavigation()) {
                if ($property->isArray()) {
                    $data[$key] = [];
                    
                    /** @var Model $model */
                    foreach ($this->{$property->getter()}() as $index => $model) {
                        $data[$key][$index] = ($model instanceof self) ? $model->toArray() : $model;
                    }
                } else {
                    /** @var Model $model */
                    $model = $this->{$property->getter()}();
                    $data[$key] = ($model instanceof self) ? $model->toArray() : $model;
                }
        
                continue;
            }
            
            // DateTime Format
            if (self::$serializedDateTimeFormat !== null && $property->getType() === DateTime::class) {
                /** @var DateTime $dateTime */
                $dateTime = $this->{$property->getter()}();
                $data[$key] = $dateTime ? $dateTime->format(self::$serializedDateTimeFormat) : null;
            } else {
                $data[$key] = $this->{$property->getter()}();
            }
        }
        
        return $data;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        try {
            /** @var string $str */
            $str = json_encode($this, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            return '';
        }
        
        return $str;
    }
    
    /**
     * @param array|null $data
     * @throws Exception
     */
    protected function loadData(array $data = null): void
    {
        if (empty($data)) {
            return;
        }
        
        foreach ($this->properties()->toArray() as $property) {
            $name = $property->getName(); // Case insesitive
        
            /** @var PropertyInfo $property */
            if (!isset($data[$name])) {
                $name = Str::snake($property->getName());
            
                if (!isset($data[$name])) {
                    $name = strtolower($property->getName());
                    if (!isset($data[$name])) {
                        continue;
                    }
                }
            }
        
            if (is_array($data[$name]) && $property->isArray() && $property->isNavigation()) {
                foreach ($data[$name] as $key => $value) {
                    $this->{$property->adder()}($this->cast($value, $property), $key);
                }
            } elseif (is_callable([$this, $property->setter()])) {
                $this->{$property->setter()}($this->cast($data[$name], $property));
            }
        }
    }
    
    /**
     * @param DateTime $date
     * @return void
     * @throws InvalidArgumentException
     */
    protected function checkDate(DateTime $date): void
    {
        if ($date->getOffset() !== 0) {
            throw new InvalidArgumentException('Timezone must be UTC+0');
        }
    }
}
