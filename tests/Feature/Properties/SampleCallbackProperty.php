<?php

namespace Sunhill\Properties\Tests\Feature\Properties;

use Sunhill\Properties\Properties\RecordProperty;
use Sunhill\Properties\Types\TypeVarchar;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Tests\Feature\Storages\SampleCallbackStorage;
use Sunhill\Properties\Properties\ArrayProperty;

class SampleCallbackProperty extends RecordProperty
{
    
    protected function initializeElements()
    {
        $this->addElement('sample_string', new TypeVarchar());
        $this->addElement('sample_integer', new TypeInteger());
        $this->addElement('sample_array', new ArrayProperty())->setAllowedElementTypes(TypeVarchar::class);
        $this->setStorage(new SampleCallbackStorage());
    }
}