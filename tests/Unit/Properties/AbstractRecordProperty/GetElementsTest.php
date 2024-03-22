<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractRecordProperty;

class GetElementsTest extends TestCase
{
    
    public function testGetElementNames()
    {
        $test = new NonAbstractRecordProperty();
        
        $elements = $test->getElementNames();
        
        $this->assertEquals(['elementA','elementB'], $elements);
    }
    
    public function testGetOwnElementNames()
    {
        $test = new NonAbstractRecordProperty();
        
        $elements = $test->getOwnElementNames();
        
        $this->assertEquals(['elementA','elementB'], $elements);        
    }
    
    public function testGetElements()
    {
        $test = new NonAbstractRecordProperty();
        
        $elements = $test->getElements();
        
        $this->assertEquals('elementA', $elements[0]->getName());        
    }
    
    public function testGetOwnElements()
    {
        $test = new NonAbstractRecordProperty();
        
        $elements = $test->getOwnElements();
        
        $this->assertEquals('elementA', $elements[0]->getName());
    }

    public function testHasElement()
    {
        $test = new NonAbstractRecordProperty();
        
        $this->assertTrue($test->hasElement('elementA'));
    }
    
}