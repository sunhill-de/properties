<?php

namespace Sunhill\Properties\Tests\Feature\Properties;

use Sunhill\Properties\Properties\RecordProperty;
use Sunhill\Properties\Types\TypeVarchar;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Tests\Feature\Storages\SampleCallbackStorage;

class SampleCallbackProperty extends RecordProperty
{
    
    protected function initializeElements()
    {
        $this->addElement('sample_string', new TypeVarchar());
        $this->addElement('sample_integer', new TypeInteger());
        $this->setStorage(new SampleCallbackStorage());
    }
}