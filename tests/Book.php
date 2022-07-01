<?php
namespace Izzle\Tests;

use DateTime;
use DateTimeZone;
use Exception;
use function is_string;
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
    protected int $id = 0;
    
    /**
     * @var string
     */
    protected string $name = '';
    
    /**
     * @var int
     */
    protected int $stockLevel = 0;
    
    /**
     * @var Page[]
     */
    protected array $pages = [];
    
    /**
     * @var Page
     */
    protected Page $currentPage;
    
    /**
     * @var BookI18n[]
     */
    protected array $i18ns = [];
    
    /**
     * @var DateTime|null
     */
    protected ?DateTime $createdAt;
    
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
     * @param mixed $key
     * @return Book
     */
    public function addPage(Page $page, $key = null): Book
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
     * @return BookI18n[]
     */
    public function getI18ns(): array
    {
        return $this->i18ns;
    }
    
    /**
     * @param BookI18n[] $i18ns
     * @return Book
     */
    public function setI18ns(array $i18ns): Book
    {
        $this->i18ns = $i18ns;
        
        return $this;
    }
    
    /**
     * @param BookI18n $i18n
     * @param mixed $key
     * @return Book
     */
    public function addI18n(BookI18n $i18n, $key = null): Book
    {
        if ($key === null) {
            $this->i18ns[] = $i18n;
        } else {
            $this->i18ns[$key] = $i18n;
        }
        
        return $this;
    }
    
    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
    
    /**
     * @param DateTime|string|null $createdAt
     * @return Book
     * @throws Exception
     */
    public function setCreatedAt($createdAt): Book
    {
        if ($createdAt === null) {
            return $this;
        }
    
        if (is_string($createdAt)) {
            $createdAt = (new DateTime($createdAt))->setTimezone(new DateTimeZone('UTC'));
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
            new PropertyInfo('i18ns', BookI18n::class, [], true, true),
            new PropertyInfo('createdAt', DateTime::class, null)
        ]);
    }
}
