<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Objects\Exceptions\MethodNotDefinedException;

class ObjectDescriptorElement extends \stdClass
{
    
    public function __construct(string $property, string $name)
    {
        $this->property = $property;
        $this->name = $name;
    }
    
    public function __call(string $name,$params)
    {
        if (Properties::propertyHasMethod($this->property,$name)) {
            $this->$name = $params;
            return $this;
        }
        if (method_exists($this, $name)) {
            $this->$name(...$params);
            return $this;
        }
        throw new MethodNotDefinedException("The method '$name' was not defined for '".$this->property."'");
    }
    
    public function embed()
    {
        $this->inclusion = 'embedded';
    }
    
    public function include()
    {
        $this->inclusion = 'included';
    }
}