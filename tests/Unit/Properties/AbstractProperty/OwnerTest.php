<?php

use Sunhill\Properties\Semantic\Name;
use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Properties\Exceptions\PropertyException;
use Sunhill\Properties\Properties\Exceptions\InvalidNameException;
use Sunhill\Properties\Properties\AbstractProperty;
use Sunhill\Properties\Tests\TestSupport\TestAbstractIDStorage;
use Sunhill\Properties\Properties\Exceptions\NoStorageSetException;
use Sunhill\Properties\Properties\Exceptions\PropertyNotReadableException;
use Sunhill\Properties\Properties\Exceptions\UserNotAuthorizedForReadingException;
use Sunhill\Properties\Tests\TestSupport\TestUserManager;
use Sunhill\Properties\Properties\Exceptions\NoUserManagerInstalledException;
use Sunhill\Properties\Properties\Exceptions\PropertyNotWriteableException;
use Sunhill\Properties\Properties\Exceptions\UserNotAuthorizedForWritingException;
use Sunhill\Properties\Properties\Exceptions\UserNotAuthorizedForModifyException;
use Sunhill\Properties\Properties\Exceptions\InvalidValueException;
use Sunhill\Properties\Properties\Exceptions\PropertyKeyDoesntExistException;
use Sunhill\Properties\Tests\TestSupport\NonAbstractProperty;

class OwnerTest extends TestCase
{
     
    public function testSetOwner()
    {
        $test1 = new NonAbstractProperty();
        $test1->setName('parent');
        
        $test2 = new NonAbstractProperty();
        $test2->setName('child');
        
        $test2->setOwner($test1);
        
        $this->assertEquals($test1, $test2->getOwner());
    }
    
    public function testGetPath()
    {
        $test1 = new NonAbstractProperty();
        $test1->setName('parent');
        
        $test2 = new NonAbstractProperty();
        $test2->setName('child');
        
        $test2->setOwner($test1);
        
        $this->assertEquals('parent.child', $test2->getPath());
    }
}