<?php

namespace Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples;

use Sunhill\Properties\Objects\AbstractPersistantRecord;
use Sunhill\Properties\Objects\ObjectDescriptor;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Types\TypeVarchar;

class EmptyChildRecord extends ParentRecord
{

    public function __construct()
    {
        AbstractPersistantRecord::__construct();
    }
    
    protected static function setupInfos()
    {
        static::addInfo('name', 'EmptyChildRecord');
        static::addInfo('description', 'A test abstract record as child.', true);
        static::addInfo('storage_id', 'emptychildrecords');
    }
    
    
}