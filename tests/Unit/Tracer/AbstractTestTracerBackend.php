<?php

namespace Sunhill\Properties\Tests\Unit\Tracer;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Markets\GetMarket;
use Sunhill\Properties\Tracer\Tracer;
use Sunhill\Properties\Tracer\Exceptions\PathNotTraceableException;
use Sunhill\Properties\Tracer\Backends\FileTracerBackend;
use Sunhill\Properties\Facades\InfoMarket;

abstract class AbstractTestTracerBackend extends TestCase
{
    
    use GetMarket;
    
    abstract protected function getBackend();
    
    public function testTraceUntraceIsTraced()
    {
        $test = $this->getBackend();
        $data = new \StdClass();
        $data->value = 'ABC';
        
        InfoMarket::shouldReceive('pathExists')->with('marketeer1.element1')->andReturn(true);
        InfoMarket::shouldReceive('requestData')->with('marketeer1.element1')->andReturn($data);
        
        $this->assertFalse($test->isTraced('marketeer1.element1'));
        $test->trace('marketeer1.element1');
        $this->assertTrue($test->isTraced('marketeer1.element1'));
        $test->untrace('marketeer1.element1');
        $this->assertFalse($test->isTraced('marketeer1.element1'));
    }
    
    public function testGetTracedElements()
    {
        $test = $this->getBackend();
        $data1 = new \StdClass();
        $data1->value = 'ABC';
        $data2 = new \StdClass();
        $data2->value = 'DEF';
        
        InfoMarket::shouldReceive('pathExists')->with('marketeer1.element1')->andReturn(true);
        InfoMarket::shouldReceive('pathExists')->with('marketeer2.element2')->andReturn(true);
        InfoMarket::shouldReceive('requestData')->with('marketeer1.element1')->andReturn($data1);
        InfoMarket::shouldReceive('requestData')->with('marketeer2.element2')->andReturn($data2);
        
        $test->trace('marketeer1.element1');
        $test->trace('marketeer2.element2');
        $this->assertEquals(['marketeer1.element1','marketeer2.element2'], $test->getTracedElements());
    }
    
    public function testGetLastPair()
    {
        $test = $this->getBackend();
        $data = new \StdClass();
        $data->value = 'ABC';
        
        InfoMarket::shouldReceive('pathExists')->with('marketeer1.element1')->andReturn(true);
        InfoMarket::shouldReceive('requestData')->with('marketeer1.element1')->andReturn($data);
        
        $test->trace('marketeer1.element1', 1000);
        
        $this->assertEquals(1000, $test->getLastChange('marketeer1.element1'));
        $this->assertEquals('ABC', $test->getLastValue('marketeer1.element1'));
    }
    
    public function testUpdate()
    {
        $test = $this->getBackend();
        $data = new \StdClass();
        $data->value = 'ABC';
        
        InfoMarket::shouldReceive('pathExists')->with('marketeer1.element1')->andReturn(true);
        InfoMarket::shouldReceive('requestData')->once()->with('marketeer1.element1')->andReturn($data);
        
        $test->trace('marketeer1.element1', 1000);
        
        $data->value = 'DEF';
        InfoMarket::shouldReceive('requestData')->once()->with('marketeer1.element1')->andReturn($data);
        
        $test->updateTraces(2000);
        $this->assertEquals(1000, $test->getFirstChange('marketeer1.element1'));
        $this->assertEquals('ABC', $test->getFirstValue('marketeer1.element1'));
        $this->assertEquals(2000, $test->getLastChange('marketeer1.element1'));
        $this->assertEquals('DEF', $test->getLastValue('marketeer1.element1'));
    }
}
