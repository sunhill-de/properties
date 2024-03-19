<?php
/**
 * @file Market.php
 * Provides the Market class as as the basic container for marketeers and properties.
 *
 * @author Klaus Dimde
 * ----------------------------------------------------------------------
 * Lang en
 * Reviewstatus: 2024-03-14
 * Localization: unknown
 * Documentation: all public
 * Tests: Unit/InfoMarket/Marketeer.php
 * Coverage: unknown
 * PSR-State: complete
 */

namespace Sunhill\Properties\InfoMarket;

use Sunhill\Properties\Properties\AbstractRecordProperty;

class Market extends AbstractRecordProperty
{
 
    /**
     * Returns if the given path exists. 
     * 
     * @param string $path
     * @return bool
     * 
     * @test Unit/InfoMarket/MarketTest::testPathExists()
     */
    public function pathExists(string $path): bool
    {
        
    }
    
    /**
     * Returns just the value of the given element or raises an exception if none exists
     * @param string $path
     */
    public function requestValue(string $path)
    {
        
    }
    
    /**
     * Takes a array of strings. Each element is a single path that is requested. The method
     * returns an associative array in the vform $path => $vLUE Or raises an exception if at
     * least one path doesn't exist. 
     * 
     * @param array $paths
     * @return array
     */
    public function requestValues(array $paths): array
    {
        
    }
    
    /**
     * Returns the metadata of the given element or raises an excpetion if the element
     * does not exist.
     * 
     * @param string $path
     * @param string $format The desired return format:$this
     * - stdclass = The metadata should be returned as a \stdClass
     * - array = The metadata should be returned as an associative array
     * - json = The metadata should be returned as a json string
     * @return array
     */
    public function requestMetadata(string $path, string $format = 'stdclass'): array
    {
        
    }
    
    /**
     * Takes an array of strings where each element represents a path which metadata
     * should be regturnes. It raises an exception if at least one element does not 
     * exist.
     * 
     * @param array $paths
     * @param string $format The desired return format:$this
     * - stdclass = The metadata should be returned as a array of StdClass
     * - array = The metadata should be returned as a array of associative arrays
     * - arrayjson = The metadata should be returned as a array of json strings
     * - json = The metadata should be returned as a json string
     * @return array
     */
    public function requestMetadatas(array $paths, string $format = 'stdclass'): array
    {
        
    }
    
    /**
     * Returns the data of the given element or raises an excpetion if the element
     * does not exist. Data is metadata and value combined
     *
     * @param string $path
     * @param string $format The desired return format:$this
     * - stdclass = The metadata should be returned as a \stdClass
     * - array = The metadata should be returned as an associative array
     * - json = The metadata should be returned as a json string
     * @return array
     */
    public function requestData(string $path, string $format = 'stdclass'): array
    {
        
    }
    
    /**
     * Takes an array of strings where each element represents a path which data
     * should be returned. Data is metadata and value combined. 
     * It raises an exception if at least one element does not
     * exist.
     *
     * @param array $paths
     * @param string $format The desired return format:$this
     * - stdclass = The metadata should be returned as a array of StdClass
     * - array = The metadata should be returned as a array of associative arrays
     * - arrayjson = The metadata should be returned as a array of json strings
     * - json = The metadata should be returned as a json string
     * @return array
     */
    public function requestDatas(array $paths, string $format = 'stdclass'): array
    {
        
    }
    
    /**
     * Tries to write the value $value to the path $path. It raises an exception if 
     * the path doesn't exist or is not writeable
     * 
     * @param string $path
     * @param unknown $value
     */
    public function putValue(string $path, $value)
    {
        
    }
    
    public function putValues(array $paths_and_values)
    {
        
    }
    
    public function isTraced(string $path): bool
    {
        
    }
    
    public function trace(string $path)
    {
        
    }
    
    public function untrace(string $path)
    {
        
    }
    
    public function updateTraces(int $stamp = 0)
    {
        if (!$stamp) {
            $stamp = now();
        }
    }
    
    public function getLastValue(string $path)
    {
        
    }
    
    public function getLastChange(string $path)
    {
        
    }
    
    
}