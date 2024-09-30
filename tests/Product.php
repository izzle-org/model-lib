<?php

namespace Izzle\Tests;

use Izzle\Model\Model;
use Izzle\Model\PropertyCollection;
use Izzle\Model\PropertyInfo;

/**
 * Class Product
 * @package Izzle\Tests
 */
class Product extends Model
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $meta;

    /**
     * @var string
     */
    protected string $description = '';

    /**
     * @param string $id
     * @return Product
     */
    public function setId(string $id): Product
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getMeta(): string
    {
        return $this->meta;
    }

    /**
     * @param string $meta
     * @return Product
     */
    public function setMeta(string $meta): Product
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return PropertyCollection
     */
    protected function loadProperties(): PropertyCollection
    {
        return new PropertyCollection([
            new PropertyInfo('id'),
            new PropertyInfo('meta'),
            new PropertyInfo('description')
        ]);
    }
}
