<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Objects\Exceptions\NameNotGivenException;
use Sunhill\Properties\Properties\AbstractProperty;

class ObjectDescriptor
{
    
    protected $owner;
    
    public function __construct($owner)
    {
        $this->owner = $owner;    
    }
    
    public function __call(string $name,$params)
    {
        if (!isset($params[0])) {
            throw new NameNotGivenException("The property '$name' has no name");
        }
        return $this->owner->appendElement($params[0], $name);
    }
    
    public function embed(string $property, string $name): AbstractProperty
    {
        return $this->owner->embedElement($name, $property);
    }
    
    public function include(string $property, string $name): AbstractProperty
    {
        return $this->owner->includeElement($name, $property);        
    }
    
}