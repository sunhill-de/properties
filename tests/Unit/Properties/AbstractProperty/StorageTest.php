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

class StorageTest extends TestCase
{
     
    public function testSetStorage()
    {
        $storage = new TestAbstractIDStorage();
        $storage->setID(1);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $this->assertEquals($storage, $test->getStorage());
        $this->assertEquals(345, $test->getValue());
    }
        
    public function testNoStorage()
    {
        $this->expectException(NoStorageSetException::class);
        $test = new NonAbstractProperty();
        
        $test->readCapability();
    }
    
    public function testGetCapabilities()
    {
        $storage = new TestAbstractIDStorage();
        $storage->setID(1);
        $storage->read_capability = 'read';
        $storage->write_capability = 'write';
        $storage->modify_capability = 'modify';
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        
        $this->assertEquals('read', $test->readCapability());
        $this->assertEquals('write', $test->writeCapability());
        $this->assertEquals('modify', $test->modifyCapability());
    }
    
    public function testPropertyNoReadable()
    {
        $storage = new TestAbstractIDStorage();
        $storage->is_readable = false;
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager(TestUserManager::class);
        
        $this->expectException(PropertyNotReadableException::class);
        $test->getValue();
    }
    
    public function testNoUserManagerInstalled()
    {
        $storage = new TestAbstractIDStorage();
        $storage->read_capability = 'read';
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager('');
        
        $this->expectException(NoUserManagerInstalledException::class);
        $test->getValue();
    }
    
    public function testUserNotAuthorizedForReading()
    {
        $storage = new TestAbstractIDStorage();
        $storage->read_capability = 'read';
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager(TestUserManager::class);
        
        $this->expectException(UserNotAuthorizedForReadingException::class);
        $test->getValue();
    }
    
    public function testUserAuthorizedForReading()
    {
        $storage = new TestAbstractIDStorage();
        $storage->read_capability = 'required';
        $storage->setID(1);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager(TestUserManager::class);
        
        $this->assertEquals(345,$test->getValue());
    }
    
    public function testFormatForHuman()
    {
        $storage = new TestAbstractIDStorage();
        $storage->setID(1);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        
        $this->assertEquals('A345',$test->getHumanValue());        
    }
    
    public function testPropertyNoWriteable()
    {
        $storage = new TestAbstractIDStorage();
        $storage->is_writeable = false;
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        
        $this->expectException(PropertyNotWriteableException::class);
        $test->setValue(1234);
    }
    
    public function testNoUserManagerInstalledWhileWriting()
    {
        $storage = new TestAbstractIDStorage();
        $storage->write_capability = 'write';
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager('');
        
        $this->expectException(NoUserManagerInstalledException::class);
        $test->setValue(123);
    }
    
    public function testUserNotAuthorizedForWriting()
    {
        $storage = new TestAbstractIDStorage();
        $storage->write_capability = 'read';
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager(TestUserManager::class);
        
        $this->expectException(UserNotAuthorizedForWritingException::class);
        $test->setValue(123);
    }
    
    public function testUserAuthorizedForWriting()
    {
        $storage = new TestAbstractIDStorage();
        $storage->write_capability = 'required';
        $storage->setID(1);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager(TestUserManager::class);
        
        $test->setValue(123);
        $this->assertTrue(true);
    }
    
    public function testUserNotAuthorizedForModify()
    {
        $storage = new TestAbstractIDStorage();
        $storage->modify_capability = 'modify';
        $storage->setValue('test_int',455);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager(TestUserManager::class);
        
        $this->expectException(UserNotAuthorizedForModifyException::class);
        $test->setValue(123);
    }    
    
    public function testNoUsermanagerWhileModify()
    {
        $storage = new TestAbstractIDStorage();
        $storage->modify_capability = 'required';
        $storage->setValue('test_int',455);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager('');
        
        $this->expectException(NoUserManagerInstalledException::class);
        $test->setValue(123);
    }
    
    public function testUserAuthorizedForModify()
    {
        $storage = new TestAbstractIDStorage();
        $storage->modify_capability = 'required';
        $storage->setValue('test_int',455);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->setUserManager(TestUserManager::class);
        
        $test->setValue(123);
        $this->assertTrue(true);
    }

    public function testPropertyNoWriteableWhileModify()
    {
        $storage = new TestAbstractIDStorage();
        $storage->is_writeable = false;
        $storage->setValue('test_int',455);
        
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        
        $this->expectException(PropertyNotWriteableException::class);
        $test->setValue(1234);
    }
    
    public function testDoSetValue()
    {
        $storage = new TestAbstractIDStorage();
        $storage->setID(1);
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        
        $test->setValue(123);
        $this->assertEquals('Input123', $storage->getValue('test_int'));
    }
    
    public function testValidateInput()
    {
        $storage = new TestAbstractIDStorage();
        $storage->setID(1);
        $test = new NonAbstractProperty();
        $test->setStorage($storage);
        $test->is_valid = false;
        
        $this->expectException(InvalidValueException::class);
        
        $test->setValue(123);
    }
    
}