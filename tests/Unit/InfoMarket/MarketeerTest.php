<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Managers\ClassManager;
use Sunhill\Properties\Facades\Classes;
use Sunhill\Properties\ORMException;
use Sunhill\Properties\Tests\Testobjects\Dummy;
use Sunhill\Properties\Tests\Testobjects\DummyChild;
use Sunhill\Properties\Tests\Testobjects\ReferenceOnly;
use Sunhill\Properties\Tests\Testobjects\SecondLevelChild;
use Sunhill\Properties\Tests\Testobjects\TestChild;
use Sunhill\Properties\Tests\Testobjects\TestParent;
use Sunhill\Properties\Tests\Testobjects\TestSimpleChild;
use Sunhill\Properties\Tests\Testobjects\ThirdLevelChild;
use Sunhill\Properties\Managers\Exceptions\ClassNotORMException;
use Sunhill\Properties\Managers\Exceptions\ClassNotAccessibleException;
use Sunhill\Properties\Objects\ORMObject;
use Sunhill\Properties\Managers\Exceptions\ClassNameForbiddenException;
use Sunhill\Properties\Properties\PropertyInteger;
use Sunhill\Properties\Properties\PropertyVarchar;
use Sunhill\Properties\Properties\PropertyBoolean;
use Sunhill\Properties\Properties\PropertyDate;
use Sunhill\Properties\Properties\PropertyObject;
use Sunhill\Properties\Properties\PropertyArray;
use Sunhill\Properties\Managers\PropertiesManager;
use Sunhill\Properties\Tests\TestSupport\NonAbstractProperty;

use Sunhill\Properties\Managers\Exceptions\PropertyClassDoesntExistException;
use Sunhill\Properties\Managers\Exceptions\GivenClassNotAPropertyException;
use Sunhill\Properties\Managers\Exceptions\PropertyNotRegisteredException;
use Sunhill\Properties\Managers\Exceptions\PropertyNameAlreadyRegisteredException;
use Sunhill\Properties\Managers\Exceptions\UnitNameAlreadyRegisteredException;
use Sunhill\Properties\Managers\Exceptions\UnitNotRegisteredException;

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
