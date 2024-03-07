<?php

namespace Sunhill\ORM\Tests\Unit\Managers;

use Sunhill\ORM\Tests\TestCase;
use Sunhill\ORM\Managers\ClassManager;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\ORMException;
use Sunhill\ORM\Tests\Testobjects\Dummy;
use Sunhill\ORM\Tests\Testobjects\DummyChild;
use Sunhill\ORM\Tests\Testobjects\ReferenceOnly;
use Sunhill\ORM\Tests\Testobjects\SecondLevelChild;
use Sunhill\ORM\Tests\Testobjects\TestChild;
use Sunhill\ORM\Tests\Testobjects\TestParent;
use Sunhill\ORM\Tests\Testobjects\TestSimpleChild;
use Sunhill\ORM\Tests\Testobjects\ThirdLevelChild;
use Sunhill\ORM\Managers\Exceptions\ClassNotORMException;
use Sunhill\ORM\Managers\Exceptions\ClassNotAccessibleException;
use Sunhill\ORM\Objects\ORMObject;
use Sunhill\ORM\Managers\Exceptions\ClassNameForbiddenException;
use Sunhill\ORM\Properties\PropertyInteger;
use Sunhill\ORM\Properties\PropertyVarchar;
use Sunhill\ORM\Properties\PropertyBoolean;
use Sunhill\ORM\Properties\PropertyDate;
use Sunhill\ORM\Properties\PropertyObject;
use Sunhill\ORM\Properties\PropertyArray;
use Sunhill\ORM\Managers\Exceptions\DuplicateEntryException;
use Sunhill\ORM\Managers\PropertiesManager;
use Sunhill\ORM\Tests\TestSupport\NonAbstractProperty;
use Sunhill\ORM\Managers\Exceptions\PropertyClassDoesntExistException;
use Sunhill\ORM\Managers\Exceptions\GivenClassNotAPropertyException;
use Sunhill\ORM\Managers\Exceptions\PropertyNotRegisteredException;

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
