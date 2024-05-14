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
    
    protected $element_references = [];
    
    protected $includes = [];
    
    protected $embeds = [];
    
    public function __construct()
    {
        $descriptor = new ObjectDescriptor($this);
        $this->initializeProperties($descriptor);
    }
    
    protected function initializeProperties(ObjectDescriptor $descriptor)
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
    
    protected function getReference(string $refering_class, string $refering_type, string $reference_kind): \stdClass
    {
        $result = new \stdClass();
        $result->class = $refering_class;
        $result->type = $refering_type;
        $result->kind = $reference_kind;        
        return $result;
    }
    
    protected function insertElement(string $name, AbstractProperty $element, string $refering_class, string $refering_type, string $reference_kind = 'append'): AbstractProperty
    {
        if (isset($this->elements[$name])) {
            throw new DuplicateElementNameException("The element '$name' already exists");
        }
        $element->setOwner($this);
        $this->elements[$name] = $element;
        $this->element_references[$name] = $this->getReference($refering_class, $refering_type, $reference_kind);

        return $element;
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
    
    protected function insertElements(AbstractRecordProperty $property, string $kind)
    {
        foreach ($property->getElements() as $name => $element) {
            $this->insertElement($name, $element, $property::class, $kind);
        }
    }
    
    public function embedElement(string $classname): AbstractProperty
    {
        if ($this->hasEmbed($classname)) {
            throw new TypeAlreadyEmbeddedException("The class '$classname' is already embedded");
        }
        $property = $this->getRecordProperty($classname);

        $this->embeds[$classname] = $property;
        
        $this->insertElements($property, 'embed');
        
        return $property;
    }
    
    public function includeElement(string $classname): AbstractProperty
    {
        if ($this->hasInclude($classname)) {
            throw new TypeAlreadyEmbeddedException("The class '$classname' is already included");
        }
        $property = $this->getRecordProperty($classname);
    
        $this->includes[$classname] = $property;
        
        $this->insertElements($property, 'include');
        
        return $property;
    }
        
    public function appendElement(string $element_name, string $class_name): AbstractProperty
    {
        $property = $this->solveProperty($class_name);
        switch ($property::class) {
            case AbstractArrayProperty::class:
                return $this->insertElement($element_name, $property, static::class,'array');
            case AbstractRecordProperty::class:
                return $this->insertElement($element_name, $property, static::class, 'record');
            default:   
                return $this->insertElement($element_name, $property, static::class,'simple');
        }
    }
    
    public function hasInclude(string $classname): bool
    {
        return isset($this->includes[$classname]);
    }
    
    public function hasEmbed(string $classname): bool
    {
        return isset($this->embeds[$classname]);        
    }
    
    public function isDirty(): bool
    {
        
    }
    
    public function commit()
    {
        
    }
    
    public function rollback()
    {
        
    }
}

