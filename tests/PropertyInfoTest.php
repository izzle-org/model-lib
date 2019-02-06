<?php
namespace Izzle\Tests;

use PHPUnit\Framework\TestCase;
use Izzle\Model\PropertyInfo;

class PropertyInfoTest extends TestCase
{
    public function testCanBeCreatedWithParameters(): void
    {
        $this->assertInstanceOf(
            PropertyInfo::class,
            new PropertyInfo('name')
        );
    
        $this->assertInstanceOf(
            PropertyInfo::class,
            new PropertyInfo('createdAt', \DateTime::class, new \DateTime('now',  new \DateTimeZone('UTC')))
        );
    }
    
    public function testCanGetGetterMethod(): void
    {
        $this->assertEquals((new PropertyInfo('name'))->getter(), 'getName');
        $this->assertEquals((new PropertyInfo('valid', 'bool', false))->getter(), 'isValid');
        $this->assertEquals((new PropertyInfo('isPartMaster', 'bool', false))->getter(), 'isPartMaster');
        $this->assertEquals((new PropertyInfo('isIsbn', 'bool', false))->getter(), 'isIsbn');
    }
    
    public function testCanGetSetterMethod(): void
    {
        $this->assertEquals((new PropertyInfo('name'))->setter(), 'setName');
        $this->assertEquals((new PropertyInfo('valid', 'bool', false))->setter(), 'setValid');
        $this->assertEquals((new PropertyInfo('isPartMaster', 'bool', false))->setter(), 'setIsPartMaster');
        $this->assertEquals((new PropertyInfo('isIsbn', 'bool', false))->setter(), 'setIsIsbn');
    }
    
    public function testCanGetAdderMethod(): void
    {
        $this->assertEquals((new PropertyInfo('names', 'string', [], false, true))->adder(), 'addName');
    }
}
