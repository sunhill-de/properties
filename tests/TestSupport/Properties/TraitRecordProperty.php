<?php

namespace Sunhill\Properties\Tests\TestSupport\Properties;

use Sunhill\Properties\Properties\RecordProperty;

class TraitRecordProperty extends RecordProperty
{
    protected function initializeElements()
    {
        $this->addElement('ownelement1', new SimpleCharProperty());
        $this->addElement('ownrecord', new NonAbstractRecordProperty());
        $this->addTrait(new NonAbstractRecordProperty());
    }   
    
}

