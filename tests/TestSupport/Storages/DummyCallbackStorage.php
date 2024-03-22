<?php

namespace Sunhill\Properties\Tests\TestSupport\Storages;

use Sunhill\Properties\Storage\CallbackStorage;

class DummyCallbackStorage extends CallbackStorage
{

     public $readwrite = 'DEF';
    
     public $uninitialized;
     
     protected function get_readonly()
     {
         return 'ABC';
     }
     
     protected function set_readwrite($value)
     {
         $this->readwrite = $value;
     }
     
     protected function get_readwrite()
     {
         return $this->readwrite;
     }
     
     protected function getcap_restricted(string $capability)
     {
         return $capability.'_cap';
     }
     
     protected function set_uninitialized($value)
     {
         $this->uninitialized = $value;
     }
     
     protected function get_uninitialized()
     {
         return $this->uninitialized;
     }
     
     protected function getinitialized_uninitialized()
     {
         return !is_null($this->uninitialized);
     }
}
