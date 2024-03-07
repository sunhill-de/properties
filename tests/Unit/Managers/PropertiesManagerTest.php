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
use Sunhill\Properties\Managers\PropertiesManager;
use Sunhill\Properties\Tests\TestSupport\NonAbstractProperty;

use Sunhill\Properties\Managers\Exceptions\PropertyClassDoesntExistException;
use Sunhill\Properties\Managers\Exceptions\GivenClassNotAPropertyException;
use Sunhill\Properties\Managers\Exceptions\PropertyNotRegisteredException;
use Sunhill\Properties\Managers\Exceptions\PropertyNameAlreadyRegisteredException;
use Sunhill\Properties\Managers\Exceptions\UnitNameAlreadyRegisteredException;
use Sunhill\Properties\Managers\Exceptions\UnitNotRegisteredException;

class PropertiesManagerTest extends TestCase
{
 
    public function testRegisterProperty() 
    {
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        
        $this->assertTrue(isset($this->getProtectedProperty($test, 'registered_properties')['NonAbstractProperty']));
    }

    public function testRegisterDoubleProperty()
    {
        $this->expectException(PropertyNameAlreadyRegisteredException::class);
        
        $test = new PropertiesManager();
        $test->registerProperty(NonAbstractProperty::class);
        $test->registerProperty(NonAbstractProperty::class);
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
    
    public function testRegisterUnit()
    {
        $test = new PropertiesManager();
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
        
        $this->assertTrue(isset($this->getProtectedProperty($test, 'registered_units')['test_name']));
    }
    
    public function testRegisterDoubleUnit()
    {
        $this->expectException(UnitNameAlreadyRegisteredException::class);
        
        $test = new PropertiesManager();
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
    }
    
    public function testUnitRegistred()
    {
        $test = new PropertiesManager();
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
        
        $this->assertTrue($test->isUnitRegistered('test_name'));
        $this->assertFalse($test->isUnitRegistered('unknown'));
    }
    
    public function testGetUnit()
    {
        $test = new PropertiesManager();
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');        
        
        $this->assertEquals('test_unit', $test->getUnit('test_name'));
    }
    
    public function testGetUnit_fail()
    {
        $this->expectException(UnitNotRegisteredException::class);
        
        $test = new PropertiesManager();
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
        
        $test->getUnit('unknown');
    }
    
    public function testGetUnitGroup()
    {
        $test = new PropertiesManager();
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');

        $this->assertEquals('test_group', $test->getUnitGroup('test_name'));
    }
    
    public function testGetUnitBasic()
    {
        $test = new PropertiesManager();
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
        
        $this->assertEquals('test_basic', $test->getUnitBasic('test_name'));
    }
    
    public function testCalculateToBasic()
    {   
        $test = new PropertiesManager();
        $test->registerUnit('test_basic','test_basicunit', 'test_group');        
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic',
            function($input) { return $input * 2; },
            function($input) { return $input / 2; } );
        $this->assertEquals(4, $test->calculateToBasic('test_name', 2));        
    }
    
    public function testCalculateFromBasic()
    {
        $test = new PropertiesManager();
        $test->registerUnit('test_basic','test_basicunit', 'test_group');
        $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic',
            function($input) { return $input * 2; },
            function($input) { return $input / 2; } );
        $this->assertEquals(2, $test->calculateFromBasic('test_name', 4));        
    }
}
