<?php

namespace Sunhill\Properties\Tests\TestSupport;

use Sunhill\Properties\Properties\AbstractRecordProperty;

class NonAbstractRecordProperty extends AbstractRecordProperty
{
    public function isValid($test): bool
    {
        return false;
    }
  
    protected function initializeElements()
    {
        $element1 = new NonAbstractProperty();
        $element1->setName('elementA');
        $element1->setOwner($this);
        
        $element2 = new NonAbstractProperty();
        $element2->setName('elementB');
        $element2->setOwner($this);
        
        $this->elements['elementA'] = $element1;
        $this->elements['elementB'] = $element2;
    }
    
    
}

