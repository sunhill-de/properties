<?php
/**
 * @file AbstractRecordProperty.php
 * Defines an abstract property as base for all record like properties
 * Lang de,en
 * Reviewstatus: 2024-02-04
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/PropertyTest.php, Unit/PropertyValidateTest.php
 * Coverage: unknown
 */

namespace Sunhill\Properties\Properties;

use Sunhill\Properties\Properties\Exceptions\CantProcessPropertyException;
use Sunhill\Properties\Properties\Exceptions\DuplicateElementNameException;
use Sunhill\Properties\Facades\Properties;

abstract class AbstractRecordProperty extends AbstractProperty
{
 
    protected $elements = [];
    
    /**
     * Clears the actual element list
     */
    protected function flushElements()
    {
        $this->elements = [];
    }
    
    /**
     * Tries to process the given $element to a property. First it checks if it is a class name, then
     * it searches for a registered property with that name. 
     * 
     * @param string $element
     * @return AbstractProperty
     * @throws CantProcessPropertyException when the given element can't be processed to a property.
     */
    protected function processStringElement(string $element): AbstractProperty
    {
        if (class_exists($element)) {
            $return = new $element();
            if (!is_a($return, AbstractProperty::class)) {
                throw new CantProcessPropertyException("The given '$element' is not a property.");
            }            
        } else {
            if (!Properties::isPropertyRegistered($element)) {
                throw new CantProcessPropertyException("The given '$element' is not the name of a property.");
            }
            $element = Properties::getPropertyNamespace($element);
            $return = new $element();
        }
        return $return;
    }

    protected function doAddElement(string $name, AbstractProperty $element)
    {
        $element->setName($name); // Here we check if the name is valid 
        if (isset($this->elements[$name])) {
            throw new DuplicateElementNameException("The element name '$name' is already in use.");
        }
        $element->setOwner($this);
        $this->elements[$name] = $element;
    }
    
    /**
     * Adds a new element to the list and returns this element
     * 
     * @param AbstractProperty|string $element
     * @return AbstractProperty
     */
    protected function addElement(string $name, $element): AbstractProperty
    {
        if (is_string($element)) {
            $element = $this->processStringElement($element);
        } else if (!is_a($element, AbstractProperty::class)) {
            if (is_scalar($element)) {
                throw new CantProcessPropertyException("Can't process '$element' to a property.");
            } else {
                throw new CantProcessPropertyException("Can't process the given parameter to a property.");
            }
        }
        $this->doAddElement($name, $element);
        return $element;    
    }
    
    /**
     * constructor just calls initializeElements()
     */
    public function __construct()
    {
        $this->initializeElements();
    }
    
    protected function initializeElements()
    {
        
    }
    
    public function getAccessType(): string
    {
        return 'record';
    }
        
}