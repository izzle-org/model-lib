<?php
namespace Izzle\Tests;

use Izzle\Model\Model;
use Izzle\Model\PropertyCollection;
use Izzle\Model\PropertyInfo;

/**
 * Class Page
 * @package Izzle\Tests
 */
class Page extends Model
{
    /**
     * @var int
     */
    protected int $page = 0;
    
    /**
     * @var string
     */
    protected string $chapter = '';
    
    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
    
    /**
     * @param int $page
     * @return Page
     */
    public function setPage(int $page): Page
    {
        $this->page = $page;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getChapter(): string
    {
        return $this->chapter;
    }
    
    /**
     * @param string $chapter
     * @return Page
     */
    public function setChapter(string $chapter): Page
    {
        $this->chapter = $chapter;
        
        return $this;
    }
    
    /**
     * @return PropertyCollection
     */
    protected function loadProperties(): PropertyCollection
    {
        return new PropertyCollection([
            new PropertyInfo('page', 'int', 0),
            new PropertyInfo('chapter')
        ]);
    }
}
