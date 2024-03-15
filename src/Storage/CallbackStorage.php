<?php
/**
 * @file SimpleCallbackStorage.php
 * A very simple storage that gets and puts values using callbacks
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

abstract class CallbackStorage extends AbstractStorage
{
    
    /**
     * Returns the required read capability or null if there is none
     * 
     * @param string $name
     * @return string
     */
    public function getReadCapability(string $name): ?string
    {
        $method = 'getcap_'.$name;
        if (method_exists($this, $method)) {
            return $this->$method('read');
        }
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
        $method = 'get_'.$name;
        return method_exists($this, $method);
    }
    
    /**
     * Performs the retrievement of the value
     * 
     * @param string $name
     */
    protected function doGetValue(string $name)
    {
        $method = 'get_'.$name;
        
        if (!method_exists($this, $method)) {
            throw new FieldNotAvaiableException("The field '$name' is not avaiable.");
        }
        return $this->$method();
    }
    
    /**
     * Returns the required write capability or null if there is none
     * 
     * @param string $name
     * @return string|NULL
     */
    public function getWriteCapability(string $name): ?string
    {
        $method = 'getcap_'.$name;
        if (method_exists($this, $method)) {
            return $this->$method('write');
        }
        return null;
    }
    
    /**
     * Returns if this property is writeable
     * @param string $name
     * @return bool
     */
    public function getIsWriteable(string $name): bool
    {
        $method = 'set_'.$name;
        return method_exists($this, $method);
    }
    
    /**
     * Returns the modify capability or null if there is none
     * 
     * @param string $name
     * @return string|NULL
     */
    public function getModifyCapability(string $name): ?string
    {
        $method = 'getcap_'.$name;
        if (method_exists($this, $method)) {
            return $this->$method('modify');
        }
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
        $method = 'set_'.$name;
        
        if (!method_exists($this, $method)) {
            throw new FieldNotAvaiableException("The field '$name' is not avaiable.");
        }
        return $this->$method($value);
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
        $method = 'getinitialized_'.$name;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return false;
    }
    
}