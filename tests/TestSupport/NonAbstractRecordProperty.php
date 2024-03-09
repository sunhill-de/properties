<?php

namespace Sunhill\Properties\Tests\TestSupport;

use Sunhill\Properties\Properties\AbstractRecordProperty;

class NonAbstractRecordProperty extends AbstractRecordProperty
{
    public function isValid($test): bool
    {
        return false;
    }
        
}

