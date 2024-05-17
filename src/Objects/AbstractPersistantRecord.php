<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Properties\AbstractRecordProperty;
use Sunhill\Properties\Properties\AbstractProperty;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\AbstractArrayProperty;
use Sunhill\Properties\Objects\Exceptions\TypeCannotBeEmbeddedException;
use Sunhill\Properties\Objects\Exceptions\TypeAlreadyEmbeddedException;
use Sunhill\Properties\Properties\Exceptions\DuplicateElementNameException;

class AbstractPersistantRecord extends AbstractRecordProperty
{
    
    protected $elements = [];
    
    protected $storage_ids = [];
    
    protected $includes = [];
    
    protected $embeds = [];
    
    public function __construct()
    {
        $this->collectProperties();
    }
    
    protected static function initializeProperties(ObjectDescriptor $descriptor)
    {
    }

    protected function hasOwnProperties(string $source): bool
    {
        return true;    
    }

    /**
     * This method is called by the construtor and calls for every member of the ancestor list the method
     * initializeProperties
     */
    protected function collectProperties()
    {
        
    }
    
    public function getElementNames()
    {
        return array_keys($this->elements);    
    }
    
    public function getElements()
    {
        return $this->elements;
    }
    
    public function getElementValues()
    {
        return array_values($this->elements);
    }
    
    public function hasElement(string $name): bool
    {
        return isset($this->elements[$name]);
    }
    
    public function getElement(string $name): AbstractProperty
    {
        return $this->elements[$name];
    }
    
    protected function solveProperty(string $name): AbstractProperty
    {
        $return = Properties::createProperty($name);
        return $return;
    }
    
    protected function getRecordProperty(string $classname): AbstractProperty
    {
        $property = $this->solveProperty($classname);
        if (!is_a($property, AbstractRecordProperty::class)) {
            throw new TypeCannotBeEmbeddedException("The given type '$classname' cant be embedded/included");
        }
        return $property;
    }
    
    /**
     * Is called when an element name is already given. Could be later used for a more intelligent way to
     * handle name collisions.
     * 
     * @param string $name
     */
    protected function handleDuplicateElements(string $name)
    {
        throw new DuplicateElementNameException("The element '$name' is already given");        
    }
    
    /**
     * Checks if the name is already given and inserts the element into the element list
     * 
     * @param string $name
     * @param AbstractProperty $element
     */
    protected function handleElement(string $name, AbstractProperty $element)
    {
        if (isset($this->elements[$name])) {
            $this->handleDuplicateElements($name);
        }
        $this->elements[$name] = $element;        
    }
    
    /**
     * Inserts the element in the storage association list.
     * 
     * @param string $name
     * @param AbstractProperty $element
     * @param string $storage_id
     */
    protected function handleStorageID(string $name, AbstractProperty $element, string $storage_id)
    {
        if (isset($this->storage_ids[$storage_id])) {
            $this->storage_ids[$storage_id][$name] = $element;
        } else {
            $this->storage_ids[$storage_id] = [$name => $element];
        }        
    }
    
    protected function insertElement(string $name, AbstractProperty $element, string $storage_id)
    {
        $this->handleElement($name, $element);
        $this->handleStorageID($name, $element, $storage_id);
    }
    
    protected function insertElements(AbstractRecordProperty $property, string $kind)
    {
        foreach ($property->getElements() as $name => $element) {
            $this->insertElement($name, $element, ($kind == 'embed')?$this->getStorageID():static::getInfo('storage_id'));
        }
    }

    protected function getStorageID()
    {
        return static::getInfo('storage_id');    
    }
    
    protected function embedOrIncludeElement(string $classname, string $kind): AbstractProperty
    {
        if ($this->hasEmbed($classname)) {
            throw new TypeAlreadyEmbeddedException("The class '$classname' is already embedded");
        }
        if ($this->hasInclude($classname)) {
            throw new TypeAlreadyEmbeddedException("The class '$classname' is already included");
        }
        
        $property = $this->getRecordProperty($classname);
        $this->insertElements($property, 'embed');
        
        return $property;
    }
    
    public function embedElement(string $classname): AbstractProperty
    {
        $property = $this->embedOrIncludeElement($classname, 'embed');
        $this->embeds[$classname] = $property;
                
        return $property;
    }
    
    public function includeElement(string $classname): AbstractProperty
    {
        $property = $this->embedOrIncludeElement($classname, 'include');
        $this->includes[$classname] = $property;
                
        return $property;
    }
        
    public function appendElement(string $element_name, string $class_name): AbstractProperty
    {
        $property = $this->solveProperty($class_name);
        switch ($property::class) {
            case AbstractArrayProperty::class:
                $this->insertElement($element_name, $property, static::class,'array');
                break;
            case AbstractRecordProperty::class:
                $this->insertElement($element_name, $property, static::class, 'record');
                break;
            default:   
                $this->insertElement($element_name, $property, static::class,'simple');
                break;
        }
        return $property;
    }
    
    public function hasInclude(string $classname): bool
    {
        return isset($this->includes[$classname]);
    }
    
    public function hasEmbed(string $classname): bool
    {
        return isset($this->embeds[$classname]);        
    }

    public function exportElements(): array
    {
        $result = [];
        return $result;
    }
    
    public function isDirty(): bool
    {
        return $this->getStorage()->isDirty();
    }
    
    public function commit()
    {
        return $this->getStorage()->commit();        
    }
    
    public function rollback()
    {
        return $this->getStorage()->rollback();        
    }
    
    public function migrate()
    {
        return $this->getStorage()->migrate();
    }
    
    public function upgrade(string $target_class)
    {
        return $this->getStorage()->upgrade($target_class);        
    }
    
    public function degrade(string $target_class)
    {
        return $this->getStorage()->degrade($target_class);        
    }
    
    public function query()
    {
        return $this->getStorage()->query();        
    }
}

