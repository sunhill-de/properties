<?php
/**
 * @file AbstractArrayProperty.php
 * Defines an abstract property as base for all array like properties
 * Lang de,en
 * Reviewstatus: 2024-02-04
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/PropertyTest.php, Unit/PropertyValidateTest.php
 * Coverage: unknown
 */

namespace Sunhill\Properties\Properties;

use Sunhill\Properties\Properties\Exceptions\InvalidParameterException;
use Mockery\Matcher\Type;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\Exceptions\InvalidValueException;

abstract class AbstractArrayProperty extends AbstractProperty implements \ArrayAccess,\Countable,\Iterator
{
     
    protected $allowed_element_types = [];
    
    private function setAllowedElementTypes_array($array): array
    {
        $result = [];
        
        foreach ($array as $element) {
            $result = array_merge($result, $this->checkElementType($element));
        }
        
        return $result;
    }
    
    private function setAllowedElementTypes_class($class): array
    {
        return [$class];        
    }
    
    private function setAllowedElementTypes_name($name): array
    {
        if (!Properties::isPropertyRegistered($name)) {
            throw new InvalidParameterException("'$name' is not a property name.");
        }
        return [Properties::getNamespaceOfProperty($name)];
    }
    
    private function checkElementType($type_or_types): array
    {
        if (is_array($type_or_types)) {
            return $this->setAllowedElementTypes_array($type_or_types);
        }
        if (is_a($type_or_types, AbstractProperty::class, true)) {
            return $this->setAllowedElementTypes_class($type_or_types);
        }
        if (is_string($type_or_types)) {
            return $this->setAllowedElementTypes_name($type_or_types);
        }
        if (is_scalar($type_or_types)) {
            throw new InvalidParameterException("The passed non scalar parameter could not be processed.");
        } else {
            throw new InvalidParameterException("The passed non scalar parameter could not be processed.");
        }        
    }
    
    /**
     * Sets the allowed element type for this array
     * @param unknown $type_or_types
     * when $type_or_types is an array each element is an allowed property type for this array
     * when $type_or_types is a string and the full qualified name of a property class then this is the allowed data Type
     * when $type_or_types is a string and the name of a property then this is the allowed data_type 
     * @return self
     */
    public function setAllowedElementTypes($type_or_types): self
    {
        if (!empty($type_or_types)) {
            $this->allowed_element_types = array_merge($this->allowed_element_types, $this->checkElementType($type_or_types));
        }
        return $this;
    }
 
    abstract protected function doOffsetSet(mixed $offset, mixed $value): void;
    
    protected function checkElementAgainstAllowed($value, string $type)
    {
        if (is_a($value, $type)) {
            return true;
        }
        $tester = new $type();
        return $tester->isValid($value);
    }
    
    protected function checkElement($value)
    {
        if (empty($this->allowed_element_types)) {
            return true; // everything is allowed
        }
        foreach ($this->allowed_element_types as $allowed_type) {
            if ($this->checkElementAgainstAllowed($value, $allowed_type)) {
                return true;
            }
        }
        return false;
    }
    
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$this->checkElement($value)) {
            if (is_scalar($value)) {
                throw new InvalidValueException("The passed value '$value' is not an allowed element type for this array.");
            } else {
                throw new InvalidValueException("The passed value is not an allowed element type for this array.");
            }
        }
        $this->doOffsetSet($offset, $value);
    }
     
    abstract protected function doOffsetGet(mixed $offset): mixed;
    
    public function offsetGet(mixed $offset): mixed
    {
        return $this->doOffsetget($offset);
    }
    
    
    public function getAccessType(): string
    {
        return 'array';
    }
    
}