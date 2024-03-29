<?php

namespace Sunhill\Properties\Tests\TestSupport\Properties;

use Sunhill\Properties\Properties\AbstractRecordProperty;

class TraitRecordProperty extends AbstractRecordProperty
{
    protected function initializeElements()
    {
        $this->addElement('ownelement1', new NonAbstractProperty());
        $this->addElement('ownrecord', new NonAbstractRecordProperty());
        $this->addTrait(new NonAbstractRecordProperty());
    }   
    
}

