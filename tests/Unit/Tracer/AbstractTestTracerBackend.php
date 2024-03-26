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
}
