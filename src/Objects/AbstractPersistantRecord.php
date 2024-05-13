<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Properties\AbstractRecordProperty;

class AbstractPersistantRecord extends AbstractRecordProperty
{
    
    public function __construct()
    {
        $descriptor = new ObjectDescriptor();
        $this->initializeProperties($descriptor);
    }
    
    protected function initializeProperties(ObjectDescriptor $descriptor)
    {
        
    }
    
    public function getElementNames()
    {
        
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
    
}