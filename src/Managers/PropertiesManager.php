<?php
 
/**
 * @file PropertyManager.php
 * Provides the PropertyManager object for accessing information about properties.
 * Replaces the classes and collection manager
 * 
 * @author Klaus Dimde
 * ----------------------------------------------------------------------
 * Lang en
 * Reviewstatus: 2024-03-04
 * Localization: unknown
 * Documentation: all public
 * Tests: Unit/Managers/ManagerPropertiesTest.php
 * Coverage: unknown
 * PSR-State: complete
 */
namespace Sunhill\ORM\Managers;

use Sunhill\ORM\Facades\Storage;
use Sunhill\ORM\Query\BasicQuery;
use Sunhill\ORM\Managers\Exceptions\InvalidAttributeIDException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Sunhill\ORM\Properties\Exceptions\InvalidNameException;
use Sunhill\ORM\Managers\Exceptions\InvalidTypeException;
use Sunhill\ORM\Managers\Exceptions\NotAnORMClassException;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Managers\Exceptions\PropertyClassDoesntExistException;
use Sunhill\ORM\Properties\AbstractProperty;
use Sunhill\ORM\Managers\Exceptions\GivenClassNotAPropertyException;
use Sunhill\ORM\Managers\Exceptions\PropertyNameAlreadyRegisteredException;
use Sunhill\ORM\Managers\Exceptions\PropertyNotRegisteredException;

/**
 * The PropertiesManager is accessed via the Properties facade. It's a singelton class
 */
class PropertiesManager 
{
    
    /**
     * Stores the currently registered properties. 
     * 
     * @var array
     */
    protected $registered_properties = [];
    
    /**
     * Clears all registered properties
     */
    public function clearRegisteredProperties()
    {
        $this->registered_properties = [];
    }
    
    /**
     * After the checks this method does the registering
     * 
     * @param string $property
     */
    protected function doRegisterProperty(string $property)
    {
       $name = $property::getInfo('name');
       if (isset($this->registerd_properties[$name])) {
           throw new PropertyNameAlreadyRegisteredException("The name '$name' of '$property' is already regsitered.");
       }
       $this->registered_properties[$name] = $property;
    }
    
    /**
     * Registered a new property to the manager
     * 
     * @param string $property
     */
    public function registerProperty(string $property)
    {
        if (!class_exists($property)) {
            throw new PropertyClassDoesntExistException("The class '$property' is not accessible.");
        }
        if (!is_a($property, AbstractProperty::class, true)) {
            throw new GivenClassNotAPropertyException("The class '$property' is not a descendant of AbstractProperty.");
        }
        $this->doRegisterProperty($property);
    }
    
    /**
     * Internal helper that tries to translate the given $property parameter into the name (and therefore
     * key in the registered_properties array) of the property.
     *
     * @param unknown $property
     * @return string|false
     */
    protected function searchProperty($property): string|false
    {
        if (is_string($property)) {
            if (array_key_exists($property, $this->registered_properties)) {
                return $property;
            }
            if ($key = array_search($property, $this->registered_properties)) {
                return $key;
            }
        }
        if (is_object($property)) {
            return $this->searchProperty($property::class);
        }
        return false;
    }
    
    protected function searchOrThrow($property): string
    {
        if ($key = $this->searchProperty($property)) {
            return $key;
        }
        if (is_scalar($property)) {
            throw new PropertyNotRegisteredException("The property '$property' is not regsitered.");
        } else {
            throw new PropertyNotRegisteredException("The given non scalar property is not registered.");
        }
    }
    
    /**
     * Returns true, when the given name or class was already registered
     * 
     * @param $property
     * @return boolean
     */
    public function isPropertyRegistered($property): bool
    {
        return ($this->searchProperty($property))==false?false:true;
    }

    /**
     * Returns the full classname with namespace of the given property
     * 
     * @param unknown $property
     * @tests PropertiesManagerTest::testGetNamespaceOfProperty
     */
    public function getNamespaceOfProperty($property)
    {
        $key = $this->searchOrThrow($property);
        return $this->registered_properties[$key];
    }
    
    /**
     * Returns the name of the given property
     * 
     * @param unknown $property
     * @return string
     * @tests PropertiesManagerTest::testGetNameOfProperty
     */
    public function getNameOfProperty($property)
    {
        $key = $this->searchOrThrow($property);
        return $key;        
    }
}
 
