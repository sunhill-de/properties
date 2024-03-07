<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Managers\ClassManager;
use Sunhill\Properties\Facades\Classes;
use Sunhill\Properties\ORMException;
use Sunhill\Properties\Tests\Testobjects\Dummy;
use Sunhill\Properties\Tests\Testobjects\DummyChild;
use Sunhill\Properties\Tests\Testobjects\ReferenceOnly;
use Sunhill\Properties\Tests\Testobjects\SecondLevelChild;
use Sunhill\Properties\Tests\Testobjects\TestChild;
use Sunhill\Properties\Tests\Testobjects\TestParent;
use Sunhill\Properties\Tests\Testobjects\TestSimpleChild;
use Sunhill\Properties\Tests\Testobjects\ThirdLevelChild;
use Sunhill\Properties\Managers\Exceptions\ClassNotORMException;
use Sunhill\Properties\Managers\Exceptions\ClassNotAccessibleException;
use Sunhill\Properties\Objects\ORMObject;
use Sunhill\Properties\Managers\Exceptions\ClassNameForbiddenException;
use Sunhill\Properties\Properties\PropertyInteger;
use Sunhill\Properties\Properties\PropertyVarchar;
use Sunhill\Properties\Properties\PropertyBoolean;
use Sunhill\Properties\Properties\PropertyDate;
use Sunhill\Properties\Properties\PropertyObject;
use Sunhill\Properties\Properties\PropertyArray;
use Sunhill\Properties\Managers\Exceptions\DuplicateEntryException;
use Sunhill\Properties\Managers\PropertiesManager;
use Sunhill\Properties\Tests\TestSupport\NonAbstractProperty;
use Sunhill\Properties\Managers\Exceptions\PropertyClassDoesntExistException;
use Sunhill\Properties\Managers\Exceptions\GivenClassNotAPropertyException;
use Sunhill\Properties\Managers\Exceptions\PropertyNotRegisteredException;

class PropertiesManagerTest extends TestCase
{
 
    public function testRegisterProperty() 
    {
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        
        $this->assertTrue(isset($this->getProtectedProperty($test, 'registered_properties')['NonAbstractProperty']));
    }

    public function testRegisterPropertyWithNonAccessibleClass()
    {
        $this->expectException(PropertyClassDoesntExistException::class);
        $test = new PropertiesManager();
        
        $test->registerProperty('something');        
    }
    
    public function testRegisterPropertyWithNoPropertyClass()
    {
        $this->expectException(GivenClassNotAPropertyException::class);
        $test = new PropertiesManager();
        
        $test->registerProperty(\StdClass::class);
    }
 
    public function testPropertyRegistred()
    {
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        
        $this->assertTrue($test->isPropertyRegistered('NonAbstractProperty'));
        $this->assertTrue($test->isPropertyRegistered(NonAbstractProperty::class));
        $this->assertTrue($test->isPropertyRegistered(new NonAbstractProperty()));
        $this->assertFalse($test->isPropertyRegistered('nonexisting'));
    }
    
    public function testGetNamespaceOfProperty_pass()
    {
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        
        $this->assertEquals(NonAbstractProperty::class, $test->getNamespaceOfProperty('NonAbstractProperty'));
        $this->assertEquals(NonAbstractProperty::class, $test->getNamespaceOfProperty(NonAbstractProperty::class));
        $this->assertEquals(NonAbstractProperty::class, $test->getNamespaceOfProperty(new NonAbstractProperty()));
    }
    
    public function testGetNamespaceOfProperty_fail()
    {
        $this->expectException(PropertyNotRegisteredException::class);
        
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        
        $test->getNamespaceOfProperty('nonexisting');
    }
    
    public function testGetNameOfProperty_pass()
    {
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        
        $this->assertEquals('NonAbstractProperty', $test->getNameOfProperty('NonAbstractProperty'));
        $this->assertEquals('NonAbstractProperty', $test->getNameOfProperty(NonAbstractProperty::class));
        $this->assertEquals('NonAbstractProperty', $test->getNameOfProperty(new NonAbstractProperty()));
    }
    
    public function testGetNameOfProperty_fail()
    {
        $this->expectException(PropertyNotRegisteredException::class);
        
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        
        $test->getNameOfProperty('nonexisting');
    }
    
    
}
