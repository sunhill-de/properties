<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Objects\Exceptions\StorageAtomTypeNotDefinedException;
use Sunhill\Properties\Objects\Exceptions\IDNotFoundException;

abstract class AbstractStorageAtom
{
    
    /**
     * The source id of the storage
     * @var string
     */
    protected $source = '';
    
    /**
     * The type of the storage (could be record, array, uuid, object)
     * @var string
     */
    protected $type = '';
    
    protected function checkType(string $type)
    {
        if (!in_array($type, ['record','array','uuid','object'])) {
            throw new StorageAtomTypeNotDefinedException("The type '$type' is not defined");
        }
    }
    
    public function setSource(string $source, string $type)
    {
        $this->source = $source;
        $this->checkType($type);
        $this->type = $type;
    }
 
    /**
     * Reads the item of the given storage depending on what type is defined
     * 
     * @param unknown $id
     * @return array
     */
    public function readItems($id): array
    {
        switch ($this->type) {
            case 'record':
                return $this->readItemsAsRecord($id);
            case 'array':
                return $this->readItemsAsArray($id);
            case 'uuid':
                return $this->readItemsAsUUID($id);
            case 'object':
                return $this->readItemsAsObject($id);
        }
    }
    
    public function idNotFound($id)
    {
        throw new IDNotFoundException("The id '$id' was not found in '".$this->source."' of type '".$this->type."'"); 
    }
    
    abstract protected function readItemsAsRecord($id): array;
    abstract protected function readItemsAsArray($id): array;
    abstract protected function readItemsAsUUID($id): array;
    abstract protected function readItemsAsObject($id): array;
    
}