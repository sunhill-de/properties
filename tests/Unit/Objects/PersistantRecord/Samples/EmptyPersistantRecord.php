<?php

namespace Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples;

use Sunhill\Properties\Objects\AbstractPersistantRecord;
use Sunhill\Properties\Objects\ObjectDescriptor;

class EmptyPersistantRecord extends AbstractPersistantRecord
{
    
    protected static function initiaölizeProperties(ObjectDescriptor $descriptor)
    {
        
    }
    
    public static $handle_inheritance = 'include';
    
    protected static function handleInheritance(): string
    {
        return self::$handle_inheritance;    
    }
}