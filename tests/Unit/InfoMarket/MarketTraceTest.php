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
     * @dataProvider UntracableProvider
     * @param string $key
     */
    public function testUntracable(string $key)
    {
        $this->expectException(PathNotTraceableException::class);
        $test = new TestMarket();
        $test->trace('marketeer3.'.$key);        
    }
    
    public static function UntracableProvider()
    {
        return [
            ['textkey'],
        ];    
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testTraceTypes(string $key)
    {
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
    public function testFirstTrace(string $key, $values)
    {
        $test = new TestMarket();
        $test->trace('marketeer3.'.$key);
        $test->updateTraces(1000);
        $this->assertEquals($values[0][1000], $test->getLastValue('marketeer3.'.$key));
        $this->assertEquals(1000, $test->getLastChange('marketeer3.'.$key));
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testUpdateTraceNoChange(string $key)
    {
        $test = new TestMarket();
        $test->trace('marketeer3.'.$key);
        $test->updateTraces(1000);
        $test->updateTraces(2000);
        $this->assertEquals(1000, $test->getLastChange('marketeer3.'.$key));
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testUpdateTraceWithChange(string $key, $values)
    {
        $test = new TestMarket();
        $test->trace('marketeer3'.$key);
        $test->updateTraces(1000);
        $test->putValue('marketeer3.'.$key,$values[2000]);
        $test->updateTraces(2000);
        $this->assertEquals($values[2000], $test->getLastValue('marketeer3.'.$key));
        $this->assertEquals(2000, $test->getLastChange('marketeer3.'.$key));
    }
    
    /**
     * @dataProvider TraceTypesProvider
     */
    public function testGetValueAt(string $key, $values)
    {
        $test = $this->setupTrace($key, $values);
        $this->assertEquals($values[1000], $test->getValueAt(1000));
        $this->assertEquals($values[1000], $test->getValueAt(1500));
        $this->assertEquals($values[2000], $test->getValueAt(2000));
    }

    public function testGetFirstValue(string $key, $values)
    {
        $test = $this->setupTrace($key, $values);
        $this->assertEquals($values[1000], $test->getFirstValue());
    }
    
    public static function TraceTypesProvider()
    {
        return [
            ['stringkey', [1000=>'ValueA',2000=>'ValueB',3000=>'ValueC']],
            ['floatkey', [1000=>3.2, 2000=>2.2]],
            ['intkey', [1000=>3, 2000=>4, 3000=>5, 4000=>6]],
            ['datekey', [1000=>'2023-12-24', 2000=>4, 3000=>5]],
            ['timekey', [1000=>'11:12:13', 2000=>4, 3000=>5]],
            ['datetimekey', [1000=>'2023-12-24 11:12:13', 2000=>4, 3000=>5]]
        ];    
    }
    
}
