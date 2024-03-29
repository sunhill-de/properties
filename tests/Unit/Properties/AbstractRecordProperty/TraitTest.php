<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractRecordProperty;
use Sunhill\Properties\Tests\TestSupport\Properties\TraitRecordProperty;

class TraitTest extends TestCase
{
    
    public function testTrait()
    {
        $test = new TraitRecordProperty();

        $test->ownelement1 = 'ABC';
        $test->ownrecord->elementA = 'DEF';
        $test->elementA = 'GHI';
        
        $this->assertEquals('ABC', $test->ownelement1);
        $this->assertEquals('DEF', $test->ownrecord->elementA);
        $this->assertEquals('GHI', $test->elementA);
    }
    
    public function testGetElementNames()
    {
        $test = new TraitRecordProperty();
        
        $elements = $test->getElementNames();
        
        $this->assertEquals(['ownelement1','ownrecord','elementA','elementB'], $elements);        
    }
    
    public function testGetOwnElementNames()
    {
        $test = new TraitRecordProperty();
        
        $elements = $test->getOwnElementNames();
        
        $this->assertEquals(['ownelement1','ownrecord'], $elements);
    }
    
    public function testGetElements()
    {
        $test = new TraitRecordProperty();
        
        $elements = $test->getElements();
        
        $this->assertEquals('ownelement1', $elements[0]->getName());
        $this->assertEquals('elementA', $elements[2]->getName());
    }
    
    public function testGetOwnElements()
    {
        $test = new TraitRecordProperty();
        
        $elements = $test->getOwnElements();
        
        $this->assertEquals('ownelement1', $elements[0]->getName());
    }
    
    public function testHasElement()
    {
        $test = new TraitRecordProperty();
        
        $this->assertTrue($test->hasElement('ownelement1'));
        $this->assertTrue($test->hasElement('elementA'));
        $this->assertFalse($test->hasElement('nonexisting'));
    }
    
}