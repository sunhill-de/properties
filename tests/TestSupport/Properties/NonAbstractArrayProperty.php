<?php

namespace Sunhill\Properties\Tests\TestSupport\Properties;

use Sunhill\Properties\Properties\AbstractArrayProperty;

class NonAbstractArrayProperty extends AbstractArrayProperty
{
    
    protected $elements = [];
    
    public function count(): int
    {
        return count($this->elements);
    }
    
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->elements[$offset]);
    }
    
    protected function doOffsetGet(mixed $offset): mixed
    {
        return $this->elements[$offset];
    }
    
    protected function doOffsetSet(mixed $offset, mixed $value): void
    {
        if (empty($offset)) {
            $this->elements[] = $value;            
        } else {
            $this->elements[$offset] = $value;
        }
    }
    
    public function offsetUnset(mixed $offset): void
    {
        
    }
    
    public function current(): mixed
    {
        
    }
    
    
    public function key(): mixed
    {
        
    }
    
    public function next(): void
    {
        
    }
    
    public function rewind(): void
    {
        
    }
    
    public function valid(): bool
    {
        
    }
    
    public function isValid($test): bool
    {
        
    }
    
}
