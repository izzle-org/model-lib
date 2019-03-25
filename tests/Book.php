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
     * @var Page[]
     */
    protected $pages = [];
    
    /**
     * @var Page
     */
    protected $currentPage;
    
    /**
     * @var \DateTime
     */
    protected $createdAt;
    
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
     * @return Page[]
     */
    public function getPages(): array
    {
        return $this->pages;
    }
    
    /**
     * @param Page[] $pages
     * @return Book
     */
    public function setPages(array $pages): Book
    {
        $this->pages = $pages;
        
        return $this;
    }
    
    /**
     * @param Page $page
     * @param string|null $key
     * @return Book
     */
    public function addPage(Page $page, string $key = null): Book
    {
        if ($key === null) {
            $this->pages[] = $page;
        } else {
            $this->pages[$key] = $page;
        }
        
        return $this;
    }
    
    /**
     * @return Page|null
     */
    public function getCurrentPage(): ?Page
    {
        return $this->currentPage;
    }
    
    /**
     * @param Page $currentPage
     * @return Book
     */
    public function setCurrentPage(Page $currentPage): Book
    {
        $this->currentPage = $currentPage;
        
        return $this;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
    
    /**
     * @param \DateTime|string|null $createdAt
     * @return Book
     * @throws \Exception
     */
    public function setCreatedAt(?\DateTime $createdAt): Book
    {
        if ($createdAt === null) {
            return $this;
        }
    
        if (\is_string($createdAt)) {
            $createdAt = (new \DateTime($createdAt))->setTimezone(new \DateTimeZone('UTC'));
        }
    
        $this->checkDate($createdAt);
        $this->createdAt = $createdAt;
        
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
            new PropertyInfo('stockLevel', 'int', 0),
            new PropertyInfo('pages', Page::class, [], true, true),
            new PropertyInfo('currentPage', Page::class, null, true),
            new PropertyInfo('createdAt', \DateTime::class, null)
        ]);
    }
}
