<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\InfoMarket\Market;
use Sunhill\Properties\InfoMarket\Exceptions\PathNotFoundException;
use Sunhill\Properties\InfoMarket\Exceptions\PathNotTraceableException;

class MarketTraceTest extends TestCase
{
 
    protected function setupTrace(string $key, $values)
    {
        $test = new TestMarket();
        $test->trace('marketeer3.'.$key);
        foreach ($values as $time => $value) {
            $test->putValue('marketeer3.'.$key, $value);
            $test->updateTrace($time);
        }
        
        return $test;
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testTraceTypes(string $key, bool $pass = true)
    {
        if (!$pass) {
            $this->expectException(PathNotTraceableException::class);
        }
        $test = new TestMarket();
        $this->assertFalse($test->isTraced('marketeer3.'.$key));
        $test->trace('marketeer3.'.$key);
        $this->assertTrue($test->isTraced('marketeer3.'.$key));
        $test->untrace('marketeer3.'.$key);
        $this->assertFalse($test->isTraced('marketeer3.'.$key));
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testFirstTrace(string $key, bool $pass = true, $values)
    {
        if (!$pass) {
            $this->expectException(PathNotTraceableException::class);
        }
        $test = new TestMarket();
        $test->trace('marketeer3.'.$key);
        $test->updateTraces(1000);
        $this->assertEquals($values[0][1000], $test->getLastValue('marketeer3.'.$key));
        $this->assertEquals(1000, $test->getLastChange('marketeer3.'.$key));
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testUpdateTraceNoChange(string $key, bool $pass = true)
    {
        if (!$pass) {
            $this->expectException(PathNotTraceableException::class);
        }
        $test = new TestMarket();
        $test->trace('marketeer3.'.$key);
        $test->updateTraces(1000);
        $test->updateTraces(2000);
        $this->assertEquals(1000, $test->getLastChange('marketeer3.'.$key));
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testUpdateTraceWithChange(string $key, bool $pass = true, $values)
    {
        if (!$pass) {
            $this->expectException(PathNotTraceableException::class);
        }
        $test = new TestMarket();
        $test->trace('marketeer3'.$key);
        $test->updateTraces(1000);
        $test->putValue('marketeer3.'.$key,$values[]);
        $test->updateTraces(2000);
        $this->assertEquals('newvalue', $test->getLastValue('marketeer3.stringkey'));
        $this->assertEquals(2000, $test->getLastChange('marketeer3.stringkey'));
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testGetValueAt(string $key, bool $pass = true, $values)
    {
        if (!$pass) {
            $this->expectException(PathNotTraceableException::class);
        }
        $test = $this->setupTrace($key, $values);
    }
    
    public static function TraceTypesProvider()
    {
        'stringkey'=>'ValueA','floatkey'=>3.2,'intkey'=>3,'boolkey'=>1,'textkey'=>'Lorep ipsum',
        'datekey'=>'2023-12-24','timekey'=>'11:12:13','datetimekey'=>'2023-12-24 11:12:13'];
        return [
            ['stringkey', true, [1000=>'ValueA',2000=>'ValueB',3000=>'ValueC']],
            ['floatkey', true, [1000=>3.2, 2000=>2.2, 3000=>1.2]],
            ['intkey', true],
            ['textkey', false],
            ['datekey', true],
            ['timekey', true],
            ['datetimekey', true]
        ];    
    }
    
}
