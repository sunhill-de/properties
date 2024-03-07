<?php

namespace Sunhill\Properties;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use \Sunhill\Properties\Managers\ClassManager;
use \Sunhill\Properties\Managers\ObjectManager;
use Sunhill\Properties\Managers\StorageManager;
use \Sunhill\Properties\Managers\TagManager;
use \Sunhill\Properties\Managers\AttributeManager;
use Sunhill\Properties\Console\MigrateObjects;
use Sunhill\Properties\Console\FlushCaches;
use Sunhill\Basic\Facades\Checks;

use Sunhill\Properties\Checks\TagChecks;
use Sunhill\Properties\Checks\ObjectChecks;
use Sunhill\Properties\Facades\Tags;

use Sunhill\Properties\Managers\OperatorManager;
use Sunhill\Properties\Managers\CollectionManager;
use Sunhill\Properties\Managers\ObjectDataGenerator;
use Sunhill\Properties\Facades\InfoMarket;
use Sunhill\Properties\InfoMarket\Market;
use Sunhill\Properties\Managers\PropertiesManager;

class SunhillServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PropertiesManager::class, function () { return new PropertiesManager(); } );
        $this->app->alias(PropertiesManager::class,'properties');        
    }
    
    protected function registerUnits()
    {
        
    }
    
    protected function registerTypes()
    {
        
    }
    
    protected function registerSemantics()
    {
        
    }
    
    public function boot()
    {
        $this->registerTypes();
        $this->registerSemantics();
        $this->registerUnits();
    }
}
