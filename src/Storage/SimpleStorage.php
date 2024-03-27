<?php
/**
 * @file SimpleStorage.php
 * A very simple storage that stores the values in an array
 * @author Klaus Dimde
 * Lang en
 * Reviewstatus: 2024-02-11
 * Localization: none
 * Documentation: unknown
 * Tests: unknown
 * Coverage: unknown
 * PSR-State: completed
 */

namespace Sunhill\Properties\Storage;

use Sunhill\Properties\Storage\Exceptions\FieldNotAvaiableException;
use Sunhill\Properties\Storage\Exceptions\FieldNotAnArrayException;

abstract class SimpleStorage extends AbstractStorage
{
    
    protected $values = [];
    
    abstract protected function readValues(): array;
    
    /**
     * Returns the required read capability or null if there is none
     * 
     * @param string $name
     * @return string
     */
    public function getReadCapability(string $name): ?string
    {
        return null;
    }
    
    /**
     * Returns if the property is readable
     * 
     * @param string $name
     * @return bool
     */
    public function getIsReadable(string $name): bool
    {
        return true;
    }
    
    /**
     * Performs the retrievement of the value
     * 
     * @param string $name
     */
    protected function doGetValue(string $name)
    {
        if (!isset($this->values[$name])) {
            throw new FieldNotAvaiableException("The field '$name' is not avaiable.");
        }
        return $this->values[$name];
    }
    
    protected function doGetIndexedValue(string $name, mixed $index): mixed
    {
        if (!isset($this->values[$name])) {
            throw new FieldNotAvaiableException("The field '$name' is not avaiable.");            
        }
        if (!is_array($this->values[$name])) {
            throw new FieldNotAnArrayException("The field '$name' is not an array.");
        }
        return $this->values[$name][$index];
    }
    
    protected function doGetElementCount(string $name): int
    {
        if (!isset($this->values[$name])) {
            throw new FieldNotAvaiableException("The field '$name' is not avaiable.");
        }
        if (!is_array($this->values[$name])) {
            throw new FieldNotAnArrayException("The field '$name' is not an array.");
        }
        return count($this->values[$name]);
    }
    /**
     * Prepares the retrievement of the value
     * 
     * @param string $name
     */
    protected function prepareGetValue(string $name)
    {
        if (empty($this->values)) {
            $this->values = $this->readValues();
        }
    }
    
    /**
     * Returns the required write capability or null if there is none
     * 
     * @param string $name
     * @return string|NULL
     */
    public function getWriteCapability(string $name): ?string
    {
        return null;
    }
    
    /**
     * Returns if this property is writeable
     * @param string $name
     * @return bool
     */
    public function getIsWriteable(string $name): bool
    {
        return false; // Simple storages are by default not weiterable 
    }
    
    /**
     * Returns the modify capability or null if there is none
     * 
     * @param string $name
     * @return string|NULL
     */
    public function getModifyCapability(string $name): ?string
    {
        return null;
    }
        
    /**
     * Performs the setting of the value
     * 
     * @param string $name
     * @param unknown $value
     */
    protected function doSetValue(string $name, $value)
    {
        // Should not be called
    }
    
    protected function doSetIndexedValue(string $name, $index, $value)
    {
        // Should not be called
    }
    
    /**
     * Returns if this storage was modified
     *
     * @return bool
     */
    public function isDirty(): bool
    {
        return false; // Cant be dirty
    }

    protected function doGetIsInitialized(string $name): bool
    {
        return true;
    }
    
}