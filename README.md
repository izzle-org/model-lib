Izzle Model Library and Classes

1) Installing
-------------

### Use Composer (*recommended*)

As IO Izzle uses [Composer][2] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `install` command to generate a new ICS application:

    php composer.phar install

Composer will install Izzle IO and all its dependencies under the specified directory.

[1]:  http://www.izzle.org
[2]:  http://getcomposer.org/

### Usage

Entity Class extending:

    class Book extends Model {}
    
Adding property informations to your new entity class

    /**
     * @return PropertyCollection
     */
    protected function loadProperties(): PropertyCollection
    {
        return (new PropertyCollection())->setProperties([
            new PropertyInfo('id', 'int', 0),
            new PropertyInfo('name', 'string'),
            new PropertyInfo('i18ns', BookI18n::class, [], true, true),
            new PropertyInfo('invisibilities', 'int', [], false, true)
        ]);
    }
