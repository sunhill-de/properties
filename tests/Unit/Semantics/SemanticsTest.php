<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Types\TypeVarchar;
use Sunhill\Properties\Exceptions\InvalidValueException;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Types\TypeFloat;
use Sunhill\Properties\Types\TypeBoolean;
use Sunhill\Properties\Types\TypeDateTime;
use Sunhill\Properties\Tests\ReadonlyDatabaseTestCase;
use Sunhill\Properties\Types\TypeDate;
use Sunhill\Properties\Types\TypeTime;
use Sunhill\Properties\Types\TypeText;
use Sunhill\Properties\Types\TypeEnum;
use Sunhill\Properties\Types\TypeCollection;
use Sunhill\Properties\Tests\Testobjects\DummyCollection;
use Sunhill\Properties\Tests\Testobjects\ComplexCollection;
use Sunhill\Properties\Tests\Testobjects\AnotherDummyCollection;

use Sunhill\Properties\Semantics\Duration;
use Sunhill\Properties\Semantics\Illuminance;
use Sunhill\Properties\Semantics\Speed;
use Sunhill\Properties\Semantics\IPv4Address;
use Sunhill\Properties\Semantics\MACAddress;
use Sunhill\Properties\Semantics\IPv6Address;
use Sunhill\Properties\Semantics\EMail;
use Sunhill\Properties\Semantics\Domain;
use Sunhill\Properties\Semantics\URL;
use Sunhill\Properties\Semantics\UUID4;
use Sunhill\Properties\Semantics\MD5;
use Sunhill\Properties\Semantics\SHA1;
use Sunhill\Properties\Semantics\Count;
use Sunhill\Properties\Semantics\Capacity;
use Sunhill\Properties\Semantics\Direction;
use Sunhill\Properties\Semantics\Age;
use Sunhill\Properties\Semantics\Airpressure;
use Sunhill\Properties\Semantics\Pressure;
use Sunhill\Properties\Semantics\Airtemperature;
use Sunhill\Properties\Semantics\Temperature;
use Sunhill\Properties\Semantics\Timestamp;

class SemanticsTest extends TestCase
{

    protected function getTestType($type, $setters)
    {
        $test = new $type();
        foreach ($setters as $name => $value) {
            $method = 'set'.$name;
            $test->$method($value);
        }
        
        return $test;
    }
    
    /**
     * @dataProvider validateProvider
     */
    public function testValidateSemantic($type, $setters, $test_input, $expect)
    {
        $test = $this->getTestType($type, $setters);
        
        if (is_callable($test_input)) {
            $this->assertEquals($expect, $test->isValid($test_input()));            
        } else {
            $this->assertEquals($expect, $test->isValid($test_input));            
        }
    }
    
    static public function validateProvider()
    {
        return [
            [Airpressure::class, [], 1024.2, true],
            [Airpressure::class, [], 'A', false],

            [Airtemperature::class, [], 14.2, true],
            [Airtemperature::class, [], 'A', false],
            
            [Age::class, [], 10, true],
            [Age::class, [], 'A', false],
            
            [Capacity::class, [], 10, true],
            [Capacity::class, [], 0, true],
            [Capacity::class, [], -1, false],
            
            [Count::class, [], 10, true],
            [Count::class, [], 0, true],
            [Count::class, [], -1, false],
            
            [Direction::class, [], 0, true],
            [Direction::class, [], 12.5, true],
            [Direction::class, [], -12.5, false],
            [Direction::class, [], 700, false],
            
            [Domain::class, [], 'example.com', true],
            [Domain::class, [], 'example$', false],
            [Domain::class, [], 'exämple.com', false],
            [Domain::class, [], 'example.com/test.html', false],
            
            [Duration::class,[],10,true],
            [Duration::class,[],'A',false],
                        
            [EMail::class, [], 'test@example.com', true],
            [EMail::class, [], 'test@example', false],
            [EMail::class, [], 'example.com', false],
            [EMail::class, [], 'töst@example.com', false],
            
            [Illuminance::class, [], 2.3, true],
            [Illuminance::class, [], 'A', false],
            
            [IPv4Address::class,[],'192.168.3.2',true],
            [IPv4Address::class,[],'abc',false],
            [IPv4Address::class,[],'192.168.3.a',false],
            [IPv4Address::class,[],'300.168.3.2',false],
            [IPV4Address::class,[],'2001:0db8:85a3:0000:0000:8a2e:0370:7334',false],

            [IPv6Address::class,[],'2001:0db8:85a3:0000:0000:8a2e:0370:7334',true],
            [IPv6Address::class,[],'2001:0db8:85a3::8a2e:0370:7334',true],
            [IPv6Address::class,[],'192.168.3.1',false],
            [IPv6Address::class,[],'2001:0DB8:85A3:0000:0000:8A2E:0370:7334',true],
            [IPv6Address::class,[],'2001:0zb8:85a3:0000:0000:8a2e:0370:7334',false],
            
            [MACAddress::class, [], '00-B0-D0-63-C2-26', true],
            [MACAddress::class, [], '00-b0-d0-63-c2-26', true],
            [MACAddress::class, [], '00-b0-d0-63-c2', false],
            [MACAddress::class, [], '00-r0-d0-63-c2-26', false],
            
            [MD5::class, [], '5d41402abc4b2a76b9719d911017c592', true],
            [MD5::class, [], '5d41402abc4b2z76b9719d911017c592', false],
            [MD5::class, [], '5d41402abc4b2a76b9719d911017c59', false],
            [MD5::class, [], '5d41402abc4b2a76b9719d911017c5923', false],
            
            [Pressure::class, [], 3.4, true],
            [Pressure::class, [], 'A', false],
            
            [SHA1::class, [], 'df589122eac0f6a7bd8795436e692e3675cadc3b', true],
            [SHA1::class, [], 'df589122eac0f6a7bd8795436e692ez675cadc3b', false],
            [SHA1::class, [], 'df589122eac0f6a7bd8795436e692e3675cadc3', false],
            [SHA1::class, [], 'df589122eac0f6a7bd8795436e692e3675cadc3bd', false],
            
            [Speed::class, [], 3.3, true],
            [Speed::class, [], 'A', false],
            
            [Temperature::class, [], 3.3, true],
            [Temperature::class, [], 'A', false],
            
            [Timestamp::class, [], '2024-03-07 15:29:00', true],
            [Timestamp::class, [], 'A', false],
            
            [URL::class, [], 'https://example.com', true],
            [URL::class, [], 'https://example.com/test.html', true],
            [URL::class, [], 'http://example.com/test.html?name=something', true],
            [URL::class, [], 'https://exämple.com/test.html', false],
            [URL::class, [], 'https://example.com/test html', false],
            
            [UUID4::class, [], 'b66f5ccd-3a64-4bf7-81e5-1ae23ab399b9', true],
            [UUID4::class, [], 'b66f5ccd-3x64-4bf7-81e5-1ae23ab399b9', false],
            [UUID4::class, [], 'b66f5ccd-3a64-abf7-81e5-1ae23ab399b9', true],
        ];
    }
    
    /**
     * @dataProvider convertProvider
     */
    public function testGetHumanValue($type, $setters, $test_input, $expect, $expect_mod = null)
    {
        $test = $this->getTestType($type, $setters);
        
        if ($expect == 'except') {
            $this->expectException(InvalidValueException::class);
        }
        
        $format = $this->callProtectedMethod($test, 'formatForHuman', [$test_input]);
        if (is_callable($expect_mod)) {
            $this->assertEquals($expect, $expect_mod($format));
        } else {
            $this->assertEquals($expect, $format);            
        }
    }
    
    static public function convertProvider()
    {
        return [
            [Capacity::class, [], 1, '1 Byte'],
            [Capacity::class, [], 1001, '1 kB'],
            [Capacity::class, [], 1101, '1.1 kB'],
            [Capacity::class, [], 1000*1000, '1 MB'],
            [Capacity::class, [], 1100*1000, '1.1 MB'],
            [Capacity::class, [], 1000*1000*1000, '1 GB'],
            [Capacity::class, [], 1100*1000*1000, '1.1 GB'],
            [Capacity::class, [], 1000*1000*1000*1000, '1 TB'],
            [Capacity::class, [], 1100*1000*1000*1000, '1.1 TB'],
            
            [Direction::class, [], 10, 'N'],
            
            [Duration::class, [], 1, '1 seconds'],
            [Duration::class, [], 60, '1 minute 0 seconds'],
            [Duration::class, [], 61, '1 minute 1 second'],
            [Duration::class, [], 62, '1 minute 2 seconds'],
            [Duration::class, [], 121, '2 minutes 1 second'],
            [Duration::class, [], 122, '2 minutes 2 seconds'],
            [Duration::class, [], 3600, '1 hour 0 minutes'],
            [Duration::class, [], 3601, '1 hour 0 minutes'],
            [Duration::class, [], 3660, '1 hour 1 minute'],
            [Duration::class, [], 3720, '1 hour 2 minutes'],
            [Duration::class, [], 7200, '2 hours 0 minutes'],
            [Duration::class, [], 7260, '2 hours 1 minute'],
            [Duration::class, [], 7320, '2 hours 2 minutes'],
            [Duration::class, [], 86400, '1 day 0 hours'],
            [Duration::class, [], 90000, '1 day 1 hour'],
            [Duration::class, [], 93600, '1 day 2 hours'],
            [Duration::class, [], 172800, '2 days 0 hours'],
            [Duration::class, [], 176400, '2 days 1 hour'],
            [Duration::class, [], 180000, '2 days 2 hours'],
            [Duration::class, [], 31536000, '1 year 0 days'],
            [Duration::class, [], 31622400, '1 year 1 day'],
            [Duration::class, [], 31708800, '1 year 2 days'],
            [Duration::class, [], 63072000, '2 years 0 days'],
        ];
    }
}