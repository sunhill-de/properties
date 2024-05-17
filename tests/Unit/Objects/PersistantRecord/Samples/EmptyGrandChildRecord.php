<?php

namespace Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples;

use Sunhill\Properties\Objects\AbstractPersistantRecord;
use Sunhill\Properties\Objects\ObjectDescriptor;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Types\TypeVarchar;

class EmptyGrandChildRecord extends EmptyChildRecord
{

    public function __construct()
    {
        $float = \Mockery::mock(TypeVarchar::class);
        $float->shouldReceive('setOwner')->andReturn($float);
        Properties::shouldReceive('createProperty')->with('float')->andReturn($float);
        $this->appendElement('grandchildfloat','float');        
    
        // Call constructor afterwars to get getInheritedElement() to work
        AbstractPersistantRecord::__construct();
    }
    
    protected static function setupInfos()
    {
        static::addInfo('name', 'EmptyGrandChildRecord');
        static::addInfo('description', 'A test abstract record as grandchild.', true);
        static::addInfo('storage_id', 'emptygrandchildrecords');
    }
    
}