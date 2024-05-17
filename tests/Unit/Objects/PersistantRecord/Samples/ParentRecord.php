<?php

namespace Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples;

use Sunhill\Properties\Objects\AbstractPersistantRecord;
use Sunhill\Properties\Objects\ObjectDescriptor;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Facades\Properties;

class ParentRecord extends AbstractPersistantRecord
{

    public function __construct()
    {
        $integer = \Mockery::mock(TypeInteger::class);
        $integer->shouldReceive('setOwner')->andReturn($integer);
        Properties::shouldReceive('createProperty')->with('integer')->andReturn($integer);
        $this->appendElement('parentint','integer');        

        parent::__construct();
    }
    
    public static $handle_inheritance = 'include';
    
    protected static function handleInheritance(): string
    {
        return self::$handle_inheritance;    
    }
    
    protected static function setupInfos()
    {
        static::addInfo('name', 'ParentRecord');
        static::addInfo('description', 'A test abstract record as parent.', true);
        static::addInfo('storage_id', 'parentrecords');
    }
       
}