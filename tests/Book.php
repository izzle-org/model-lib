<?php
namespace Izzle\Tests;

use Izzle\Model\Model;
use Izzle\Model\PropertyCollection;
use Izzle\Model\PropertyInfo;

/**
 * Class Book
 * @package Izzle\Tests
 */
class Book extends Model
{
    /**
     * @var int
     */
    protected $id = 0;
    
    /**
     * @var string
     */
    protected $name = '';
    
    /**
     * @var int
     */
    protected $stockLevel = 0;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return Book
     */
    public function setName(string $name): Book
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getStockLevel(): int
    {
        return $this->stockLevel;
    }
    
    /**
     * @param int $stockLevel
     * @return Book
     */
    public function setStockLevel(int $stockLevel): Book
    {
        $this->stockLevel = $stockLevel;
        
        return $this;
    }
    
    /**
     * @return PropertyCollection
     */
    protected function loadProperties(): PropertyCollection
    {
        return new PropertyCollection([
            new PropertyInfo('name'),
            new PropertyInfo('id', 'int', 0),
            new PropertyInfo('stockLevel', 'int', 0)
        ]);
    }
}
