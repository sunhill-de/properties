<?php
/**
 * @file AbstractTracerBackend.php
 * Provides a basic class for tracer backends that do the work for the tracer facade
 *
 * @author Klaus Dimde
 * ----------------------------------------------------------------------
 * Lang en
 * Reviewstatus: 2024-03-24
 * Localization: unknown
 * Documentation: all public
 * Tests: 
 * Coverage: unknown
 * PSR-State: complete
 */

namespace Sunhill\Properties\Tracer;

use Sunhill\Properties\InfoMarket\Market;
use Sunhill\Properties\Tracer\Exceptions\PathAlreadyTracedException;
use Sunhill\Properties\Tracer\Exceptions\PathNotTracedException;
use Sunhill\Properties\InfoMarket\Exceptions\PathNotFoundException;

abstract class AbstractTracerBackend
{
    
    /**
     * Stores the current market. Passed by the tracer facade
     * 
     * @var Market
     */
    protected $market;
    
    /**
     * The constructor. Just takes the current market from the facade
     * 
     * @param Market $market
     */
    public function __construct(Market $market)
    {
        $this->market = $market;    
    }
    
    /**
     * Tells the tracer backend to execute the tracing 
     * 
     * @param string $path
     */
    abstract protected function doTrace(string $path);
    
    /**
     * Tells the tracer backend to trace the passed path in the future.
     * It raises an exception when this path is already traced
     * 
     * @param string $path
     */
    public function trace(string $path)
    {
        if ($this->isTraced($path)) {
            throw new PathAlreadyTracedException("The path '$path' is already traced.");
        }
        if (!$this->market->pathExists($path)) {
            throw new PathNotFoundException("The path '$path' does not exist.");
        }
    }
    
    /**
     * Tells the tracer backend to untrace the path
     * 
     * @param string $path
     */
    abstract protected function doUntrace(string $path);
    
    /**
     * Tells the tracer backend to untrace the passed path in the future.
     * It raises an exception when this path is not already traced. All history data will be deleted
     *
     * @param string $path
     */
    public function untrace(string $path)
    {
        if (!$this->isTraced($path)) {
            throw new PathNotTracedException("The path '$path' is already traced.");
        }        
    }

    abstract protected function getIsTraced(string $path): bool;
    
    /**
     * Returns if the passed path is traced. 
     * 
     * @param string $path
     */
    public function isTraced(string $path)
    {
        if (!$this->market->pathExists($path)) {
            throw new PathNotFoundException("The path '$path' does not exist.");
        }
        return $this->getIsTraced($path);
    }
    
    public function updateTraces(int $timestamp = 0)
    {
        if (!$timestamp) {
            $timestamp = now();
        }
    }
    
    public function getLastValue(string $path)
    {
        
    }
    
    public function getLastChange(string $path)
    {
        
    }
    
    public function getValueAt(string $path,int $timestamp)
    {
        
    }
    
    public function getFirstValue(string $path)
    {
        
    }
    
    public function getFirstChange(string $path)
    {
        
    }
    
    public function getRangeStatistics(string $path, int $start, int $end): \StdClass
    {
        
    }
    
    public function getRangeValues(string $path, int $start, int $end, int $step): array
    {
        
    }
}