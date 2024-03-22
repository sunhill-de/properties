<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\InfoMarket\Market;
use Sunhill\Properties\InfoMarket\Exceptions\MarketeerHasNoNameException;
use Sunhill\Properties\InfoMarket\Exceptions\CantProcessMarketeerException;
use Sunhill\Properties\Tests\TestSupport\Marketeers\TestMarketeer1;
use Sunhill\Properties\Tests\TestSupport\Marketeers\TestMarketeer2;

class MarketRegisterTest extends TestCase
{
 
    public function testRegisterMarketeer()
    {
        $test = new Market();
        $this->assertFalse($test->hasMarketeer('marketeer1'));
        $test->registerMarketeer(new TestMarketeer1());
        $this->assertTrue($test->hasMarketeer('marketeer1'));
    }
    
    public function testRegisterMarketeerAsClassname()
    {
        $test = new Market();
        $test->registerMarketeer(TestMarketeer1::class);
        $this->assertTrue($test->hasMarketeer('marketeer1'));        
    }
    
    public function testRegisterMarketeerWithName()
    {
        $test = new Market();
        $test->registerMarketeer(TestMarketeer2::class,'marketeer2');
        $this->assertTrue($test->hasMarketeer('marketeer2'));        
    }
    
    public function testRegisterMarketeerWithNoMarketeer()
    {
        $this->expectException(CantProcessMarketeerException::class);
        
        $test = new Market();
        $test->registerMarketeer('noclass','marketeer2');
    }
    
    public function testRegisterMarketeerWithNoName()
    {
        $this->expectException(MarketeerHasNoNameException::class);
        
        $test = new Market();
        $test->registerMarketeer(TestMarketeer2::class);
    }
    
}
