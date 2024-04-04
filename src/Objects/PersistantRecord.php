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
    public static function getPropertyDefinition(): array
    {
        $list = new PropertyList(static::class);
        
        if (!static::hasNoOwnProperties()) {
            static::setupProperties($list);
        }
        
        return $list->toArray();
    }
        
    protected static function setupProperties(PropertyList $list)
    {
    }
        
}