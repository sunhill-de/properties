<?php
/**
 * @file PropertyLIst.php
 * Defines a helper class that makes it easier to define properties 
 * Lang de,en
 * Reviewstatus: 2024-04-04
 * Localization: complete
 * Documentation: complete
 * Tests:
 * Coverage: unknown
 */

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Properties\AbstractProperty;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Managers\Exceptions\PropertyNotRegisteredException;
use Sunhill\Properties\Properties\Exceptions\DuplicateElementNameException;

class PropertyList implements \Iterator
{
    protected $properties = [];
    
    protected $current;
    
    /**
     * Checks if this property list has a property with the name '$name'
     * 
     * @param string $name
     * @return bool
     */
    public function hasProperty(string $name): bool
    {
        return isset($this->properties[$name]);    
    }
    
    /**
     * Adds the property $property with the name $name to this list
     *  
     * @param string $name
     * @param AbstractProperty $property
     * @return AbstractProperty
     */
    public function addProperty(string $name, AbstractProperty $property): AbstractProperty
    {
        if (isset($this->properties[$name])) {
            throw new DuplicateElementNameException("The property name '$name' is already in use.");
        }
        $this->properties[$name] = $property;
        return $property;
    }
       
    /**
     * Catchall method that makes it possible to just use ->integer() to add an integer property
     * 
     * @param string $name
     * @param unknown $params
     * @return unknown
     * @throws PropertyNotRegisteredException::class when the given property is not registered
     */
    public function __call(string $name, $params)
    {
        $property_ns = Properties::getNamespaceOfProperty($name);
        
        $property = new $property_ns();        
        $property->setName($params[0]);
        
        $this->addProperty($params[0], $property);
        
        return $property;
    }
    
    public function current(): mixed
    {
        return $this->properties[array_keys($this->properties)[$this->current]];
    }
    
    public function key(): mixed
    {
        return array_keys($this->properties)[$this->current];
    }
    
    public function next(): void
    {
        $this->current++;
    }
    
    public function rewind(): void
    {
        $this->current = 0;    
    }
    
    public function valid(): bool
    {
        return (($this->current >= 0) && ($this->current < count($this->properties)));
    }
}