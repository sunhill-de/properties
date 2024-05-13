<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Properties\AbstractRecordProperty;
use Sunhill\Properties\Properties\AbstractProperty;

class AbstractPersistantRecord extends AbstractRecordProperty
{
    
    protected $elements = [];
    
    protected $element_references = [];
    
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
        
    }
    
    public function getElementValues()
    {
        
    }
    
    public function hasElement(string $name): bool
    {
        
    }
    
    public function getElement(string $name): AbstractProperty
    {
        
    }
    
    public function embedElement(string $classname): AbstractProperty
    {
        
    }
    
    public function includeElement(string $classname): AbstractProperty
    {
        
    }
    
    public function appendElement(string $element_name, string $class_name): AbstractProperty
    {
        
    }
    
    public function hasInclude(string $classname): bool
    {
        
    }
    
    public function hasEmbed(string $classname): bool
    {
        
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

