<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\NonAbstractRecordProperty;
use Sunhill\Properties\Tests\TestSupport\NonAbstractProperty;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\Exceptions\CantProcessPropertyException;

class IterateTest extends TestCase
{
    
    public function testIterate()
    {
        $test = new NonAbstractRecordProperty();
        
        $key_str = '';
        $value_str = '';
        
        foreach ($test as $key => $value) {
            $key_str .= $key;
            $value_str .= $value->getName();
        }
        
        $this->assertEquals('elementAelementB', $key_str);
        $this->assertEquals('elementAelementB', $value_str);
    }
    
}