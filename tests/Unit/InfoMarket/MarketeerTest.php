<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Marketeers\TestMarketeer1;
use Sunhill\Properties\Tests\TestSupport\Marketeers\TestMarketeer2;

class MarketeerTest extends TestCase
{
    public function testSimpleRead()
    {
        $test = new TestMarketeer1();
        
        $result = $test->requestItem(['element1']);
        
        $this->assertEquals('ValueA', $result->getValue());
    }
    
    public function testReadUnknown()
    {
        $test = new TestMarketeer1();
        
        $result = $test->requestItem(['unknown']);
        
        $this->assertNull($result);        
    }
    
    public function testGetOffer()
    {
        $test = new TestMarketeer1();
        
        $result = $test->getElementNames();
        
        $this->assertEquals('element1', $result[0]);
    }
    
    public function testNestedCall()
    {
        $test = new TestMarketeer2();
        
        $result = $test->requestItem(['key3','element2']);
        
        $this->assertEquals('valueB', $result->getValue());
    }
    
    public function testNestedUnknownCall()
    {
        $test = new TestMarketeer2();
        
        $result = $test->requestItem(['key3','unknown']);
        
        $this->assertNull($result);
    }
}
