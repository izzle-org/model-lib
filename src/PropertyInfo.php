<?php
namespace Izzle\Model;

use Izzle\Support\Str;
use function sprintf;
use function ucfirst;

class PropertyInfo
{
    /**
     * @var string
     */
    protected $name = '';
    
    /**
     * @var string
     */
    protected $type = 'string';
    
    /**
     * @var mixed
     */
    protected $default;
    
    /**
     * @var bool
     */
    protected $navigation = false;
    
    /**
     * @var bool
     */
    protected $array = false;
    
    /**
     * @var bool
     */
    protected $hidden = false;
    
    /**
     * PropertyInfo constructor.
     * @param string $name
     * @param string $type
     * @param string $default
     * @param bool $navigation
     * @param bool $array
     * @param bool $hidden - Hidden for serialization
     */
    public function __construct(
        string $name,
        string $type = 'string',
        $default = '',
        bool $navigation = false,
        bool $array = false,
        bool $hidden = false
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->default = $default;
        $this->navigation = $navigation;
        $this->array = $array;
        $this->hidden = $hidden;
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
     * @return PropertyInfo
     */
    public function setName(string $name): PropertyInfo
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @param string $type
     * @return PropertyInfo
     */
    public function setType(string $type): PropertyInfo
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }
    
    /**
     * @param mixed $default
     * @return PropertyInfo
     */
    public function setDefault($default): PropertyInfo
    {
        $this->default = $default;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isNavigation(): bool
    {
        return $this->navigation;
    }
    
    /**
     * @param bool $navigation
     * @return PropertyInfo
     */
    public function setNavigation(bool $navigation): PropertyInfo
    {
        $this->navigation = $navigation;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isArray(): bool
    {
        return $this->array;
    }
    
    /**
     * @param bool $array
     * @return PropertyInfo
     */
    public function setArray(bool $array): PropertyInfo
    {
        $this->array = $array;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }
    
    /**
     * @param bool $hidden
     * @return PropertyInfo
     */
    public function setHidden(bool $hidden): PropertyInfo
    {
        $this->hidden = $hidden;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getter(): string
    {
        $prefix = 'get';
        $name = $this->getName();
        if ($this->type === 'bool') {
            $prefix = 'is';
            $name = preg_replace('/^is(.+)$/s', '$1', $this->getName()); // Removing leading 'is' in name
        }
        
        return sprintf('%s%s', $prefix, ucfirst(Str::camel($name)));
    }
    
    /**
     * @return string
     */
    public function setter(): string
    {
        return sprintf('set%s', ucfirst(Str::camel($this->getName())));
    }
    
    /**
     * @return string
     */
    public function adder(): string
    {
        return sprintf('add%s', ucfirst(Str::camel(Str::singular($this->getName()))));
    }
}
