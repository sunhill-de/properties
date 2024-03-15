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
use Sunhill\Properties\InfoMarket\Market;
use Couchbase\Exception\PathNotFoundException;

class DummyMarket extends Market
{
    
    protected function initializeElements()
    {
        $this->addElement('marketeer1', new TestMarketeer1());    
        $this->addElement('marketeer2', new TestMarketeer2());
    }
    
}

class MarketTest extends TestCase
{
 
    public function testPathExists()
    {
        $test = new DummyMarket();
        
        $this->assertTrue($test->pathExists('marketeer1.element1'));
        $this->assertTrue($test->pathExists('marketeer2.key3.element2'));
        $this->assertFalse($test->pathExists('marketeer1.nonexisting'));
        $this->assertFalse($test->pathExists('nonexisting.nonexisting'));
        $this->assertFalse($test->pathExists('marketeer2.key3.nonexisting'));
    }
    
    public function testSimpleRequestValue()
    {
        $test = new DummyMarket();
        
        $this->assertEquals('ValueA',$test->requestValue('marketeer1.element1'));
    }
    
    public function testComplexRequestValue()
    {
        $test = new DummyMarket();
        
        $this->assertEquals('value2', $test->requestValue('marketeer2.key3.element2'));
    }
    
    public function testRequestUnknownValue()
    {
        $test = new DummyMarket();
        $this->expectException(PathNotFoundException::class);
        $test->requestValue('marketeer1.unknown');        
    }
}
