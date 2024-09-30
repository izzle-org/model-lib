<?php

namespace Izzle\Tests;

use Izzle\Model\Model;
use Izzle\Model\PropertyCollection;
use Izzle\Model\PropertyInfo;

/**
 * Class BookI18n
 * @package Izzle\Tests
 */
class BookI18n extends Model
{
    /**
     * @var string
     */
    protected string $name = '';

    /**
     * @var string|null
     */
    protected ?string $description = null;

    /**
     * @var string
     */
    protected string $locale = 'de_DE';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return BookI18n
     */
    public function setName(string $name): BookI18n
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return BookI18n
     */
    public function setDescription(?string $description): BookI18n
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return BookI18n
     */
    public function setLocale(string $locale): BookI18n
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function loadProperties(): PropertyCollection
    {
        return new PropertyCollection([
            new PropertyInfo('name'),
            new PropertyInfo('description'),
            new PropertyInfo('locale')
        ]);
    }
}
