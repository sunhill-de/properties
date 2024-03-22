<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractProperty;

class InfomarketTest extends TestCase
{
     
    public function testGetMetadata()
    {
        $test = new NonAbstractProperty();
        
        $metadata = $test->getMetadata();
        
        $this->assertEquals('ASAP', $metadata['update']);
        $this->assertEquals('none', $metadata['unit']);
        $this->assertEquals('none', $metadata['semantic']);
    }
    
 }