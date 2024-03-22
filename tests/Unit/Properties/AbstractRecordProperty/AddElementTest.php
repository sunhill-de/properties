<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\Exceptions\CantProcessPropertyException;
use Sunhill\Properties\Properties\Exceptions\DuplicateElementNameException;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractRecordProperty;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractProperty;

class AddElementTest extends TestCase
{
    
    public function testAddByObject()
    {
        $test = new NonAbstractRecordProperty();
        $element = new NonAbstractProperty();
        
        $this->callProtectedMethod($test, 'addElement', ['test',$element]);
        
        $this->assertEquals('test',$element->getName());
        $this->assertEquals($test,$element->getOwner());
    }
    
    public function testAddByClassname()
    {
        $test = new NonAbstractRecordProperty();

        $element = $this->callProtectedMethod($test, 'addElement', ['test',NonAbstractProperty::class]);

        $this->assertEquals('test',$element->getName());
        $this->assertEquals($test,$element->getOwner());        
    }
    
    public function testAddByPropertyName()
    {
        $test = new NonAbstractRecordProperty();
        
        Properties::shouldReceive('isPropertyRegistered')->once()->with('test_property')->andReturn(true);
        Properties::shouldReceive('getPropertyNamespace')->once()->with('test_property')->andReturn(NonAbstractProperty::class);
        
        $element = $this->callProtectedMethod($test, 'addElement', ['test', 'test_property']);

        $this->assertEquals('test',$element->getName());
        $this->assertEquals($test,$element->getOwner());        
    }
    
    public function testFailedDueDupplicate()
    {
        $test = new NonAbstractRecordProperty();
        $element = new NonAbstractProperty();
        
        $this->expectException(DuplicateElementNameException::class);
        
        $this->callProtectedMethod($test, 'addElement', ['test',$element]);
        $this->callProtectedMethod($test, 'addElement', ['test',$element]);
    }
    
    public function testFailedObject()
    {
        $test = new NonAbstractRecordProperty();
        $this->expectException(CantProcessPropertyException::class);        

        $this->callProtectedMethod($test, 'addElement', ['test', new \StdClass()]);        
    }
    
    public function testFailedClassname()
    {
        $test = new NonAbstractRecordProperty();
        $this->expectException(CantProcessPropertyException::class);

        $this->callProtectedMethod($test, 'addElement', ['test', \StdClass::class]);        
    }
    
    public function testFailedPropertyName()
    {
        $test = new NonAbstractRecordProperty();
        $this->expectException(CantProcessPropertyException::class);
        
        $this->callProtectedMethod($test, 'addElement', ['test', 'unknown']);        
    }
    
}