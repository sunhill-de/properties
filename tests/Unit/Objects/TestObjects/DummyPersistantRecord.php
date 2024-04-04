<?php

namespace Sunhill\Properties\Tests\Unit\Objects\TestObjects;

use Sunhill\Properties\Objects\PersistantRecord;
use Sunhill\Properties\Objects\PropertyList;

class DummyPersistantRecord extends PersistantRecord
{
    
    protected static function setupProperties(PropertyList $list)
    {
        $list->integer('dummyint');
    }
    
}