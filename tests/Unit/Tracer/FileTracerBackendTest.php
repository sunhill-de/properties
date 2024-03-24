<?php

namespace Sunhill\Properties\Tests\Unit\Tracer;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Markets\GetMarket;
use Sunhill\Properties\Tracer\Tracer;
use Sunhill\Properties\Tracer\Exceptions\PathNotTraceableException;
use Sunhill\Properties\Tracer\Backends\FileTracerBackend;

class FileTracerBackendTest extends TestCase
{
    
    use GetMarket;
    
    protected function getTracerBackend()
    {
        echo dirname(__FILE__).'/../../temp';
        array_map('unlink', glob(dirname(__FILE__).'/../../temp/*'));
        
        $market = $this->getMarket();
        $test = new FileTracerBackend($market);
        $test->setTracerDir(dirname(__FILE__).'/../../temp');
        
        return $test;
    }

    public function testTraceUntraceIsTraced()
    {
        $test = $this->getTracerBackend();
        
        $this->assertFalse($test->isTraced('marketeer1.element1'));
        $test->trace('marketeer1.element1');
        $this->assertTrue($test->isTraced('marketeer1.element1'));
        $test->untrace('marketeer1.element1');
        $this->assertFalse($test->isTraced('marketeer1.element1'));
    }
}
