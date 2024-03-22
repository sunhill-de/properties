<?php

namespace Sunhill\Properties\Tracer;

class Tracer
{
    
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