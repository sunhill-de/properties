<?php

use Sunhill\Properties\Semantic\Name;
use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Properties\Property;
use Sunhill\Properties\Properties\Exceptions\PropertyException;
use Sunhill\Properties\Units\None;
use Sunhill\Properties\Objects\ORMObject;
use Sunhill\Properties\Properties\Exceptions\InvalidNameException;
use Sunhill\Properties\Properties\AbstractProperty;
use Sunhill\Properties\Tests\TestSupport\TestAbstractIDStorage;
use Sunhill\Properties\Properties\AbstractRecordProperty;

class NonAbstractRecordProperty extends AbstractRecordProperty
{
    public function isValid($test): bool
    {
        
    }
    
    
}

class AbstractRecordPropertyTest extends TestCase
{
     
}