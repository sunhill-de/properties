<?php

namespace Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples;

use Sunhill\Properties\Objects\AbstractPersistantRecord;
use Sunhill\Properties\Objects\ObjectDescriptor;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Types\TypeVarchar;

class ChildRecord extends ParentRecord
{

    public function __construct()
    {
        $varchar = \Mockery::mock(TypeVarchar::class);
        $varchar->shouldReceive('setOwner')->andReturn($varchar);
        Properties::shouldReceive('createProperty')->with('varchar')->andReturn($varchar);
        $this->appendElement('childvarchar','varchar');        

        // Call constructor afterwars to get getInheritedElements() to work
        AbstractPersistantRecord::__construct();
    }
    
    protected static function setupInfos()
    {
        static::addInfo('name', 'ChildRecord');
        static::addInfo('description', 'A test abstract record as child.', true);
        static::addInfo('storage_id', 'childrecords');
    }    
    
}