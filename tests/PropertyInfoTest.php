<?php

namespace Izzle\Tests;

use DateTime;
use DateTimeZone;
use Izzle\Model\PropertyInfo;
use PHPUnit\Framework\TestCase;

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
            new PropertyInfo('createdAt', DateTime::class, new DateTime('now', new DateTimeZone('UTC')))
        );
    }

    public function testCanGetGetterMethod(): void
    {
        $this->assertEquals((new PropertyInfo('name'))->getter(), 'getName');
        $this->assertEquals((new PropertyInfo('valid', 'bool', false))->getter(), 'isValid');
        $this->assertEquals((new PropertyInfo('isPartMaster', 'bool', false))->getter(), 'isPartMaster');
        $this->assertEquals((new PropertyInfo('isIsbn', 'bool', false))->getter(), 'isIsbn');
        $this->assertEquals((new PropertyInfo('isbn', 'string', ''))->getter(), 'getIsbn');
    }

    public function testCanGetSetterMethod(): void
    {
        $this->assertEquals((new PropertyInfo('name'))->setter(), 'setName');
        $this->assertEquals((new PropertyInfo('valid', 'bool', false))->setter(), 'setValid');
        $this->assertEquals((new PropertyInfo('isPartMaster', 'bool', false))->setter(), 'setIsPartMaster');
        $this->assertEquals((new PropertyInfo('isIsbn', 'bool', false))->setter(), 'setIsIsbn');
        $this->assertEquals((new PropertyInfo('isbn', 'string', ''))->setter(), 'setIsbn');
    }

    public function testCanGetAdderMethod(): void
    {
        $this->assertEquals((new PropertyInfo('names', 'string', [], false, true))->adder(), 'addName');
    }
}
