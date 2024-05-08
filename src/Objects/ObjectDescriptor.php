<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Objects\Exceptions\NameNotGivenException;

class ObjectDescriptor
{
    
    public function __call(string $name,$params)
    {
        if (Properties::propertyExists($name)) {
            if (!isset($params[0])) {
                throw new NameNotGivenException("The property '$name' has no name");
            }
            $prop_name = $params[0];
            $element = new ObjectDescriptorElement($name, $prop_name);
            $this->$prop_name = $element;
            return $element;
        }
    }
    
}