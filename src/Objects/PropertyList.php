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

class PropertyList
{
    protected $properties = [];
    
    public function hasProperty(string $name): bool
    {
        return isset($this->properties[$name]);    
    }
    
    public function addProperty(string $name, AbstractProperty $property): AbstractProperty
    {
        $this->properties[$name] = $property;
        return $property:
    }
        
    public function __call(string $name, $params)
    {
        
    }
    
}