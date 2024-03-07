<?php
/**
 * @file AbstractArrayProperty.php
 * Defines an abstract property as base for all array like properties
 * Lang de,en
 * Reviewstatus: 2024-02-04
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/PropertyTest.php, Unit/PropertyValidateTest.php
 * Coverage: unknown
 */

namespace Sunhill\Properties\Properties;

use Sunhill\Properties\Properties\Exceptions\InvalidNameException;
use Sunhill\Properties\Properties\Exceptions\PropertyNotReadableException;
use Sunhill\Properties\Properties\Exceptions\UserNotAuthorizedForReadingException;
use Sunhill\Properties\Properties\Exceptions\NoUserManagerInstalledException;

abstract class AbstractArrayProperty extends AbstractProperty implements \ArrayAccess,\Countable,\Iterator
{
       
    public function getAccessType(): string
    {
        return 'array';
    }
    
}