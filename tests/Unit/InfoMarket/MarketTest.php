<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\InfoMarket\Market;
use Sunhill\Properties\InfoMarket\Exceptions\PathNotFoundException;

class MarketTest extends TestCase
{
 
    public function testPathExists()
    {
        $test = new TestMarket();
        
        $this->assertTrue($test->pathExists('marketeer1.element1'));
        $this->assertTrue($test->pathExists('marketeer2.key3.element2'));
        $this->assertFalse($test->pathExists('marketeer1.nonexisting'));
        $this->assertFalse($test->pathExists('nonexisting.nonexisting'));
        $this->assertFalse($test->pathExists('marketeer2.key3.nonexisting'));
    }
    
    public function testSimpleRequestValue()
    {
        $test = new TestMarket();
        
        $this->assertEquals('ValueA',$test->requestValue('marketeer1.element1'));
    }
    
    public function testComplexRequestValue()
    {
        $test = new TestMarket();
        
        $this->assertEquals('value2', $test->requestValue('marketeer2.key3.element2'));
    }
    
    public function testRequestValues()
    {
        $test = new TestMarket();
        
        $values = $test->requestValues(['marketeer1.element1','marketeer2.key3.element1']);
        
        $this->assertEquals('ValueA',$values['marketeer1.element1']);
        $this->assertEquals('ValueA',$values['marketeer2.key3.element1']);
    }
    
    public function testRequestUnknownValue()
    {
        $test = new TestMarket();
        $this->expectException(PathNotFoundException::class);
        $test->requestValue('marketeer1.unknown');        
    }
    
    public function testRequestUnknownValues()
    {
        $test = new TestMarket();
        $this->expectException(PathNotFoundException::class);
        $values = $test->requestValues(['marketeer1.element1','marketeer2.unknown.element1']);
    }
    
    public function testRequestMetadata()
    {
        $test = new TestMarket();
        
        $metadata = $test->requestMetadata('marketeer1.element2');
    }
    
    public function testRequestMetadatas()
    {
        
    }
    
    public function testRequestData()
    {
        
    }
}
