<?php

namespace Sunhill\Properties\Objects;

use Sunhill\Properties\Storage\AbstractIDStorage;

abstract class AbstractPersistantStorage extends AbstractIDStorage
{
    
    protected $persistant_record;
    
    public function __construct(AbstractPersistantRecord $record)
    {
        $this->persistant_record = $record;    
    }
    
    /**
     * Alias for setID()
     * 
     * @param int $id
     */
    public function load(int $id)
    {
        $this->setID($id);    
    }
    
    abstract protected function getStorageAtom(string $action): AbstractStorageAtom;
    
    protected function addItems(array $items)
    {
        $this->values = array_merge($this->values, $items);    
    }
    
    protected function readFromStorage(int $id, string $storage_id, array $storage_descriptor, AbstractStorageAtom $atom)
    {
        $this->addItems($atom->loadRecord($id, $storage_id, $storage_descriptor));
    }
    
    protected function readFromID(int $id)
    {
        $atom = $this->getStorageAtom('load');
        $this->addItems($atom->loadDirectory($id));
        
        $storages = $this->persistant_record->exportElements();
        foreach ($storages as $storage => $storage_descriptor) {
            $this->readFromStorage($id, $storage, $storage_descriptor, $atom);
        }
    }

    protected function collectValues(array $descriptor): array
    {
        $result = [];
        foreach ($descriptor as $key => $value) {
            $result[$key] = $this->getValue($key);
        }
        return $result;
    }
    
    protected function storeToStorage(int $id, string $storage_id, array $storage_descriptor, AbstractStorageAtom $atom)
    {
        $values = $this->collectValues($storage_descriptor);
        $atom->storeRecord($id, $storage_id, $storage_descriptor, $values);
    }
        
    protected function writeToID(): int
    {
        $atom = $this->getStorageAtom('store');
        $id = $atom->storeDirectory();

        $storages = $this->persistant_record->exportElements();
        foreach ($storages as $storage => $storage_descriptor) {
            $this->storeToStorage($id, $storage, $storage_descriptor, $atom);
        }
        
        return $id;
    }
    
    protected function updateToStorage(int $id, string $storage_id, array $storage_descriptor, AbstractStorageAtom $atom)
    {
        $values = $this->collectValues($storage_descriptor);
        $atom->updateRecord($id, $storage_id, $storage_descriptor, $values);        
    }
    
    protected function updateToID(int $id)
    {
        $atom = $this->getStorageAtom('update');
        $atom->updateDirectory($id);

        $storages = $this->persistant_record->exportElements();
        foreach ($storages as $storage => $storage_descriptor) {
            $this->updateToStorage($id, $storage, $storage_descriptor, $atom);
        }
    }

    protected function deleteStorage(int $id, string $storage_id, array $storage_descriptor, AbstractStorageAtom $atom)
    {
        $atom->deleteRecord($id, $storage_id, $storage_descriptor);
    }
    
    public function delete(?int $id = null)
    {
        if (is_null($id)) {
            $id = $this->getID();
        }
        $atom = $this->getStorageAtom('delete');
        $atom->deleteDirectory($id);
        $storages = $this->persistant_record->exportElements();
        foreach ($storages as $storage => $storage_descriptor) {
            $this->deleteStorage($id, $storage, $storage_descriptor, $atom);
        }
    }
    
    public function getReadCapability(string $name) : ?string
    {
        return null;
        // No need to test
    }
    
    public function getIsReadable(string $name) : bool
    {
        return true;
    }
    
    public function getIsWriteable(string $name) : bool
    {
        return true;
    }
    
    public function doGetValue(string $name)
    {
        return $this->values[$name];
    }
    
    public function getWriteCapability(string $name) : ?string
    {
        return null;
    }
    
    public function getWriteable(string $name) : bool
    {
        return true;
    }
    
    protected function doGetIsInitialized(string $name) : bool
    {
        return true;
    }
    
    public function getModifyCapability(string $name) : ?string
    {
        return null;
    }
        
}