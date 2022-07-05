<?php
namespace Izzle\Model;

use ArrayIterator;
use IteratorAggregate;
use function array_values;
use Countable;
use InvalidArgumentException;
use JsonSerializable;

class PropertyCollection implements JsonSerializable, Countable, IteratorAggregate
{
    /**
     * @var PropertyInfo[]
     */
    private array $container = [];
    
    /**
     * PropertyCollection constructor.
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        $this->setProperties($properties);
    }
    
    /**
     * @param PropertyInfo $property
     * @return PropertyCollection
     */
    public function addProperty(PropertyInfo $property): PropertyCollection
    {
        $this->container[$property->getName()] = $property;
        
        return $this;
    }
    
    /**
     * @param array $properties
     * @return PropertyCollection
     * @throws InvalidArgumentException
     */
    public function addProperties(array $properties): PropertyCollection
    {
        foreach ($properties as $property) {
            if (!($property instanceof PropertyInfo)) {
                throw new InvalidArgumentException('Values of properties must be of type PropertyInfo');
            }
            
            $this->container[$property->getName()] = $property;
        }
        
        return $this;
    }
    
    /**
     * @param PropertyInfo $property
     * @return PropertyCollection
     */
    public function removeProperty(PropertyInfo $property): PropertyCollection
    {
        unset($this->container[$property->getName()]);
        
        return $this;
    }
    
    /**
     * @param array $properties
     * @return PropertyCollection
     * @throws InvalidArgumentException
     */
    public function setProperties(array $properties): PropertyCollection
    {
        $this->container = [];
        foreach ($properties as $property) {
            if (!($property instanceof PropertyInfo)) {
                throw new InvalidArgumentException('Array must contain only PropertyInfo objects');
            }
            
            $this->addProperty($property);
        }
        
        return $this;
    }
    
    /**
     * @param string $name
     * @return bool
     */
    public function hasProperty(string $name): bool
    {
        return isset($this->container[$name]);
    }
    
    /**
     * @param string $name
     * @return PropertyInfo|null
     */
    public function getProperty(string $name): ?PropertyInfo
    {
        return $this->container[$name] ?? null;
    }
    
    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->container);
    }
    
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
    
    /**
     * @return PropertyInfo[]
     */
    public function toArray(): array
    {
        return array_values($this->container);
    }
    
    /**
     * @inheritDoc
     */
    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->container);
    }
}
