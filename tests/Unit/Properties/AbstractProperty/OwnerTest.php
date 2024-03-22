<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractProperty;

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