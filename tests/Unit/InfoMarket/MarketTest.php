<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\InfoMarket\Market;
use Sunhill\Properties\InfoMarket\Exceptions\PathNotFoundException;
use Sunhill\Properties\InfoMarket\Exceptions\MarketeerHasNoNameException;
use Sunhill\Properties\InfoMarket\Exceptions\CantProcessMarketeerException;

class MarketTest extends TestCase
{
 
    use GetMarket;
        
    public function testPathExists()
    {
        $test = $this->getMarket();
        
        $this->assertTrue($test->pathExists('marketeer1.element1'));
        $this->assertTrue($test->pathExists('marketeer2.key3.element2'));
        $this->assertFalse($test->pathExists('marketeer1.nonexisting'));
        $this->assertFalse($test->pathExists('nonexisting.nonexisting'));
        $this->assertFalse($test->pathExists('marketeer2.key3.nonexisting'));
    }
    
    public function testSimpleRequestValue()
    {
        $test = $this->getMarket();
        
        $this->assertEquals('ValueA',$test->requestValue('marketeer1.element1'));
    }
    
    public function testSimpleRequestValueAsJson()
    {
        $test = $this->getMarket();
        
        $this->assertEquals('"ValueA"',$test->requestValue('marketeer1.element1','json'));
    }
    
    public function testComplexRequestValue()
    {
        $test = $this->getMarket();
        
        $this->assertEquals('valueB', $test->requestValue('marketeer2.key3.element2'));
    }
    
    public function testRequestValues()
    {
        $test = $this->getMarket();
        
        $values = $test->requestValues(['marketeer1.element1','marketeer2.key3.element1']);
        
        $this->assertEquals('ValueA',$values['marketeer1.element1']);
        $this->assertEquals('ValueA',$values['marketeer2.key3.element1']);
    }
    
    public function testRequestValuesAsJson()
    {
        $test = $this->getMarket();
        
        $values = $test->requestValues(['marketeer1.element1','marketeer2.key3.element1'],'json');
        
        $this->assertEquals('{"marketeer1.element1":"ValueA","marketeer2.key3.element1":"ValueA"}', $values);
    }
    
    public function testRequestUnknownValue()
    {
        $test = $this->getMarket();
        
        $this->expectException(PathNotFoundException::class);
        $test->requestValue('marketeer1.unknown');        
    }
    
    public function testRequestUnknownValues()
    {
        $test = $this->getMarket();
        $this->expectException(PathNotFoundException::class);
        $values = $test->requestValues(['marketeer1.element1','marketeer2.unknown.element1']);
    }
    
    public function testRequestMetadataAsArray()
    {
        $test = $this->getMarket();
        
        $metadata = $test->requestMetadata('marketeer1.element2','array');
        
        $this->assertEquals('string', $metadata['type']);
    }
    
    public function testRequestMetadataAsStdclass()
    {
        $test = $this->getMarket();
        
        $metadata = $test->requestMetadata('marketeer1.element2');
        
        $this->assertEquals('string', $metadata->type);
    }
    
    public function testRequestMetadataAsJson()
    {
        $test = $this->getMarket();
        
        $metadata = $test->requestMetadata('marketeer1.element2','json');
        
        $this->assertTrue(strpos($metadata, '"type":"string"') > 0);
    }
    
    public function testRequestMetadatasAsArray()
    {
        $test = $this->getMarket();
        
        $metadatas = $test->requestMetadatas(['marketeer1.element1','marketeer2.key3.element1'], 'array');
        
        $this->assertEquals('string', $metadatas['marketeer1.element1']['type']);
    }
    
    public function testRequestMetadatasAsStdclass()
    {
        $test = $this->getMarket();
        
        $metadatas = $test->requestMetadatas(['marketeer1.element1','marketeer2.key3.element1'], 'stdclass');
        
        $this->assertEquals('string', $metadatas->{"marketeer1.element1"}->type);
    }
    
    public function testRequestMetadatasAsJson()
    {
        $test = $this->getMarket();
        
        $metadatas = $test->requestMetadatas(['marketeer1.element1','marketeer2.key3.element1'], 'json');
        
        $this->assertTrue(strpos($metadatas, '"type":"string"') > 0);
    }
    
    public function testRequestData()
    {
        
    }
}
