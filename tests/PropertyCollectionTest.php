<?php
namespace Izzle\Tests;

use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Izzle\Model\PropertyCollection;
use Izzle\Model\PropertyInfo;

class PropertyCollectionTest extends TestCase
{
    public function testCanBeCreatedWithProperties(): void
    {
        $this->assertInstanceOf(
            PropertyCollection::class,
            new PropertyCollection([
                new PropertyInfo('name'),
                new PropertyInfo('value', 'int', 0)
            ])
        );
    }
    
    public function testCanBeCreatedWithoutProperties(): void
    {
        $this->assertInstanceOf(
            PropertyCollection::class,
            new PropertyCollection()
        );
    }
    
    public function testCanBeConvertedToArray(): void
    {
        $this->assertIsArray(
            (new PropertyCollection([
                new PropertyInfo('name')
            ]))->toArray()
        );
    }
    
    public function testImplementsJson(): void
    {
        $this->assertInstanceOf(
            JsonSerializable::class,
            new PropertyCollection()
        );
    }
    
    public function testCanBeConvertedToJson(): void
    {
        $this->assertJson(
            json_encode(new PropertyCollection([
                new PropertyInfo('name')
            ]))
        );
    }
    
    public function testCanAddProperty(): void
    {
        $collection = new PropertyCollection([
            new PropertyInfo('value', 'int', 0)
        ]);
        
        $collection->addProperty(new PropertyInfo('name'));
        
        $this->assertCount(2, $collection->toArray());
    }
    
    public function testCanAddProperties(): void
    {
        $collection = new PropertyCollection([
            new PropertyInfo('value', 'int', 0)
        ]);
        
        $collection->addProperties([
            new PropertyInfo('name'),
            new PropertyInfo('valid', 'bool', false)
        ]);
        
        $this->assertCount(3, $collection->toArray());
        
        $collection->addProperties([
            new PropertyInfo('name'),
            new PropertyInfo('price', 'float', 0.0)
        ]);
        
        $this->assertCount(4, $collection->toArray());
    }
    
    public function testCanSetProperties(): void
    {
        $collection = new PropertyCollection([
            new PropertyInfo('value', 'int', 0)
        ]);
        
        $collection->setProperties([
            new PropertyInfo('name'),
            new PropertyInfo('valid', 'bool', false)
        ]);
        
        $this->assertCount(2, $collection->toArray());
    }
    
    public function testCanRemoveProperty(): void
    {
        $property = new PropertyInfo('name');
        $collection = new PropertyCollection([
            new PropertyInfo('value', 'int', 0)
        ]);
        
        $collection->addProperty($property);
        
        $this->assertCount(2, $collection->toArray());
        
        $collection->removeProperty($property);
        
        $this->assertCount(1, $collection->toArray());
    }
    
    public function testCanTellIfPropertyExists(): void
    {
        $property = new PropertyInfo('name');
        $collection = new PropertyCollection([
            $property
        ]);
        
        $this->assertTrue($collection->hasProperty($property->getName()));
    }
    
    public function testCanGetPropertyByName(): void
    {
        $property = new PropertyInfo('name');
        $collection = new PropertyCollection([
            $property
        ]);
        
        $this->assertEquals(
            $property,
            $collection->getProperty($property->getName())
        );
    }
    
    public function testCanGetPropertiesCount(): void
    {
        $collection = new PropertyCollection([
            new PropertyInfo('name'),
            new PropertyInfo('valid', 'bool', false)
        ]);
        
        $this->assertEquals(2, $collection->count());
    }
}
