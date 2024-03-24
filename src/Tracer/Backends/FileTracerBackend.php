<?php
/**
 * @file FileTracerBackend.php
 * Provides a tracer backend that stores the traces in a file system
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

namespace Sunhill\Properties\Tracer\Backends;

use Sunhill\Properties\Tracer\AbstractTracerBackend;

class FileTracerBackend extends AbstractTracerBackend
{
    
    protected $tracer_dir;
    
    public function setTracerDir(string $dir)
    {
        $this->tracer_dir = $dir;
    }
    
    public function getTracerDir()
    {
        if (empty($this->tracer_dir)) {
           return env('TRACER_DIR'); 
        }
        return $this->tracer_dir;
    }
    
    protected function doTrace(string $path)
    {
        
    }
    
    protected function doUntrace(string $path)
    {
        
    }
    
    protected function getIsTraced(string $path): bool
    {
        return file_exists($this->getTracerDir().'/'.$path);
    }
    
}