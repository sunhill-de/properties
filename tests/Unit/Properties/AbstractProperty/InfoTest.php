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

class InfoTest extends TestCase
{
     
    public function testUnknownMethod()
    {
        $this->expectException(PropertyException::class);
        
        $test = new NonAbstractProperty();
        $test->unknownMethod();
    }
 
    public function testGetInfo()
    {
        $this->assertEquals('NonAbstractProperty', NonAbstractProperty::getInfo('name'));    
    }

    public function testGetNonexistingInfo()
    {
        $this->expectException(PropertyKeyDoesntExistException::class);
        NonAbstractProperty::getInfo('nonexisting');
    }
    
    public function testGetNonexistingInfoWithDefault()
    {
        $this->assertEquals('default',NonAbstractProperty::getInfo('nonexisting','default'));
    }
    
    public function testTranslateGetInfo()
    {
        $this->assertEquals('trans:A base test class for an abstract property.', NonAbstractProperty::getInfo('description'));
    }
    
    public function testHasKey()
    {
        $this->assertTrue(NonAbstractProperty::hasInfo('userkey'));
        $this->assertFalse(NonAbstractProperty::hasInfo('nonexisting'));
    }
    
    public function testGetAllKeys()
    {
        $info = NonAbstractProperty::getAllInfos();
        $this->assertTrue(isset($info['userkey']));
    }
    
}