<?php
/**
 * @file RecordProperty.php
 * Defines an property as base for all record like properties
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
use Sunhill\Properties\Properties\Exceptions\PropertyDoesntExistException;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Storage\AbstractStorage;
use Sunhill\Properties\Properties\Exceptions\StorageAlreadySetException;
use Sunhill\Properties\Storage\StaticStorage;
use Ramsey\Collection\AbstractArray;

class RecordProperty extends AbstractProperty implements \Iterator
{
 
    /**
     * Stores the actual elements
     * @var array
     */
    protected $elements = [];
    
    /**
     * Clears the actual element list
     */
    protected function flushElements()
    {
        $this->elements = [];
    }
    
    /**
     * Sotres the action traits
     * @var array
     */
    protected $traits = [];
    
    /**
     * Clears the actual traits list
     */
    protected function flushTraits()
    {
        $this->traits = [];
    }
    
    protected function setItemsStorage(AbstractStorage $storage)
    {
        foreach ($this->elements as $element) {
            $element->setStorage($storage);
        }
    }
    
    protected function setTraitsStorage(AbstractStorage $storage)
    {
        foreach ($this->traits as $trait) {
            $trait->setStorage($storage);
        }
    }
    
    public function setStorage(AbstractStorage $storage)
    {
        parent::setStorage($storage);
        $this->setItemsStorage($storage);
        $this->setTraitsStorage($storage);
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
        if (!is_null($this->storage)) {
            $element->setStorage($this->storage);
        }
        $this->elements[$name] = $element;
    }

    private function getElement($element): AbstractProperty
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
        return $element;
    }
    
    /**
     * Adds a new element to the list and returns this element
     * 
     * @param AbstractProperty|string $element
     * @return AbstractProperty
     */
    protected function addElement(string $name, $element): AbstractProperty
    {
        $element = $this->getElement($element);
        $this->doAddElement($name, $element);
        return $element;    
    }
   
    /**
     * Adds a new element to the list and returns this element. 
     * For now a public alias for addElement()
     * @param string $name
     * @param unknown $element
     * @return AbstractProperty
     */
    public function appendElement(string $name, $element): AbstractProperty
    {
        return $this->addElement($name, $element);
    }
    
    private function doAddTrait($element)
    {
        $this->traits[] = $element;    
    }
    
    protected function addTrait($element): AbstractProperty
    {
        $element = $this->getElement($element);
        $this->doAddTrait($element);
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
    
    /**
     * A direct assign to a record property is always invalid
     * {@inheritDoc}
     * @see \Sunhill\Properties\Properties\AbstractProperty::isValid()
     */
    public function isValid($input): bool
    {
        return false;
    }
    
// ****************************** Iterator **************************************
    protected $current = 0;
    
    public function current(): mixed
    {
        return $this->elements[$this->key()];
    }
    
    public function key(): mixed
    {
        return array_keys($this->elements)[$this->current];        
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
        return $this->current < count($this->elements);
    }
    
// ************************ getElements ***********************************
    public function getElementNames()
    {
        $result = $this->getOwnElementNames();
        foreach ($this->traits as $trait) {
            $result = array_merge($result, $trait->getElementNames());
        }
        return $result;
    }
    
    public function getOwnElementNames()
    {
        return array_keys($this->elements);        
    }
    
    public function getElements()
    {
        $result = $this->getOwnElements();
        foreach ($this->traits as $trait) {
            $result = array_merge($result, $trait->getElements());
        }
        return $result;
    }
    
    public function getOwnElements()
    {
        return array_values($this->elements);
    }
    
    public function hasElement(string $name)
    {
        if (isset($this->elements[$name])) {
            return true;
        }
        foreach ($this->traits as $trait) {
            if ($trait->hasElement($name)) {
                return true;
            }
        }
        return false;    
    }
    
// ************************** transparent element handling *****************************
    protected function doGetValue()
    {
        return $this;
    }
    
    protected function dispatchGetElement(AbstractProperty $element)
    {
        if (is_a($element, AbstractArrayProperty::class)) {
            return $element;
        }
        return $element->getValue();        
    }
    
    public function __get(string $name)
    {
        if (!$this->hasElement($name) && !$this->handleUnkownRead($name)) {            
            throw new PropertyDoesntExistException("The property '$name' doesnt exist.");
        }
        if (isset($this->elements[$name])) {
            return $this->dispatchGetElement($this->elements[$name]);
        }
        foreach ($this->traits as $trait) {
            if ($trait->hasElement($name)) {
                return $trait->$name;
            }
        }
    }
    
    protected function handleUnkownRead(string $name)
    {
        return false;    
    }
    
    public function __set(string $name, $value)
    {
        if (!$this->hasElement($name) && !$this->handleUnkownWrite($name, $value)) {
            throw new PropertyDoesntExistException("The property '$name' doesnt exist.");
        }
        if (isset($this->elements[$name])) {
            $this->elements[$name]->setValue($value);
            return;
        }
        foreach ($this->traits as $trait) {
            if ($trait->hasElement($name)) {
                $trait->$name = $value;
                return;
            }
        }
    }
    
    protected function handleUnkownWrite(string $name, $value)
    {
        return false;
    }
    
// ***************************** Infomarket *******************************************
    /**
     * Try to pass the request to a child element. If none is found return null
     * @param string $name
     * @param array $path
     * @return NULL
     */
    protected function passItemRequest(string $name, array $path)
    {
        if ($this->hasElement($name)) {
            return $this->elements[$name]->requestItem($path);
        }
        return parent::passItemRequest($name, $path);
    }
    
    public function static()
    {
        if (!is_null($this->storage)) {
            throw new StorageAlreadySetException('static() called and a storage was already set.');
        }
        $this->setStorage(new StaticStorage());
    }
}