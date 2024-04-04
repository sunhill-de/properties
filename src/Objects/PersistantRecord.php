<?php
/**
 * @file PersistantRecord.php
 * Defines a common basic class for collections and objects
 * Lang de,en
 * Reviewstatus: 2024-04-04
 * Localization: complete
 * Documentation: complete
 * Tests: 
 * Coverage: unknown
 */

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Properties\RecordProperty;
use Sunhill\Properties\Storage\AbstractStorage;
use Sunhill\Properties\Properties\Exceptions\NoStorageSetException;

/**
 * The basic class for collections. A collection is a simple kind of persistant object that 
 * has no inheritance. 
 * @author lokal
 *
 */
class PersistantRecord extends RecordProperty
{
   
    /**
     * Returns, if this record has its own setupProperties method or only the inhertited
     * @return boolean
     */
    public static function hasNoOwnProperties(): bool
    {
        $reflector = new \ReflectionMethod(static::class, 'setupProperties');
        return ($reflector->getDeclaringClass()->getName() !== static::class);
    }
    
    /**
     * A static method that returns all properties that this class defines (not the inherited)
     *
     * @return array
     *
     * test: 
     */
    public static function getPropertyDefinition()
    {
        $list = new PropertyList(static::class);
        
        if (!static::hasNoOwnProperties()) {
            static::setupProperties($list);
        }
        
        return $list;
    }
        
    protected static function setupProperties(PropertyList $list)
    {
    }
 
    protected function initializeElements()
    {
        $property_list = static::getPropertyDefinition();
        foreach ($property_list as $key => $property) {
            $this->addElement($key, $property);
        }
    }

    protected function getPersistantStorage(string $action): AbstractStorage
    {
        // The base class can't define a default storage
        throw new NoStorageSetException("There is no storage set: $action");        
    }
    
    protected function checkForStorage(string $action)
    {
        if (empty($this->storage)) {
            $this->storage = $this->getPersitantStorage($action);
        }
        return $this->storage;
    }
    
}