<?php
namespace Izzle\Model;

use Izzle\Support\Str;

abstract class Model implements \JsonSerializable
{
    /**
     * @var PropertyCollection
     */
    private $propertyCollection;
    
    /**
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
            foreach ($this->properties()->toArray() as $property) {
                $name = $property->getName();
                
                /** @var PropertyInfo $property */
                if (!isset($data[$name])) {
                    $name = Str::snake($property->getName());
                    
                    if (!isset($data[$name])) {
                        continue;
                    }
                }
                
                if ($property->isArray() && $property->isNavigation() && \is_array($data[$name])) {
                    foreach ($data[$name] as $key => $value) {
                        $this->{$property->adder()}($this->cast($value, $property), $key);
                    }
                } else {
                    $this->{$property->setter()}($this->cast($data[$name], $property));
                }
            }
        }
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
     */
    public function cast($value, PropertyInfo $property)
    {
        if ($property->isNavigation()) {
            if ($value instanceof self) {
                return $value;
            }
            
            $class = $property->getType();
            return \is_array($value) ? new $class($value) : new $class();
        }
        
        $cast = function ($value, PropertyInfo $property) {
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
                    return \utf8_encode((string) $value);
                case \DateTime::class:
                    return \is_string($value) ? new \DateTime($value, new \DateTimeZone('UTC')) : $value;
                case 'mixed':
                    return $value;
            }
        };
        
        if (!$property->isNavigation() && $property->isArray() && \is_array($value)) {
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
    public function jsonSerialize()
    {
        return $this->toArray();
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this->properties()->toArray() as $property) {
            /** @var PropertyInfo $property */
            if ($property->isHidden()) {
                continue;
            }
            
            $data[Str::snake($property->getName())] = $this->{$property->getter()}();
        }
        
        return $data;
    }
    
    /**
     * @param \DateTime $date
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function checkDate(\DateTime $date): void
    {
        if ($date->getTimezone()->getName() !== 'UTC') {
            throw new \InvalidArgumentException('Timezone must be UTC');
        }
    }
}
