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
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Types\TypeBoolean;
use Sunhill\Properties\Types\TypeDate;
use Sunhill\Properties\Types\TypeDateTime;
use Sunhill\Properties\Types\TypeEnum;
use Sunhill\Properties\Types\TypeFloat;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Types\TypeText;
use Sunhill\Properties\Types\TypeTime;
use Sunhill\Properties\Types\TypeVarchar;

class SunhillServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PropertiesManager::class, function () { return new PropertiesManager(); } );
        $this->app->alias(PropertiesManager::class,'properties');        
    }
    
    protected function registerUnits()
    {
        Properties::registerUnit('none','','none');

        // *********************************** Length ******************************************
        Properties::registerUnit('meter','m','length');
        Properties::registerUnit('centimeter','cm','length','meter',
            function($input) { return $input / 100; },
            function($input) { return $input * 100; });
        Properties::registerUnit('millimeter','mm','length','meter',
            function($input) { return $input / 1000; },
            function($input) { return $input * 1000; });
        Properties::registerUnit('kilometer','km','length','meter',
            function($input) { return $input * 1000; },
            function($input) { return $input / 1000; });

        // ************************************ weight *****************************************
        Properties::registerUnit('kilogramm','kg','weight');
        Properties::registerUnit('gramm','g','weight','kilogramm',
            function($input) { return $input / 1000; },
            function($input) { return $input * 1000; });
        
        // ************************************ Temperature ***************************************
        Properties::registerUnit('degreecelsius','°C','temperature');
        Properties::registerUnit('degreekelvin','K','temperature','degreecelsius',
            function($input) { return $input - 273.15; },
            function($input) { return $input + 273.15; });
        Properties::registerUnit('degreefahrenheit','F','temperature','degreecelsius',
            function($input) { return ($input - 32) * 5/9; },
            function($input) { return $input * 1.8 + 32; });
        
        // ********************************** Speed ************************************************
        Properties::registerUnit('meterpersecond','m/s','speed');
        Properties::registerUnit('kilometerperhour','km/h','speed','meterpersecond',
            function($input) { return $input / 3.6; },
            function($input) { return $input * 3.6; });
        
        // ********************************* Time ****************************************
        Properties::registerUnit('second','s','duration');
        Properties::registerUnit('minute','min','duration','second',
            function($input) { return $input * 60; },
            function($input) { return $input / 60; });
        Properties::registerUnit('hour','h','duration','second',
            function($input) { return $input * 3600; },
            function($input) { return $input / 3600; });
        
        // ******************************** Angle ****************************************
        Properties::registerUnit('degree','°','angle');
        
        // ******************************** Ratio **********************************************
        Properties::registerUnit('percent','%','ratio');
        
        // ********************************* Capacity ****************************************
        Properties::registerUnit('byte','B','capacity');
        Properties::registerUnit('kilobyte','KB','capacity','byte',
            function($input) { return $input * 1000; },
            function($input) { return $input / 1000; });
        Properties::registerUnit('megabyte','MB','capacity','byte',
            function($input) { return $input * 1000000; },
            function($input) { return $input / 1000000; });
    }
    
    protected function registerTypes()
    {
        Properties::registerProperty(TypeBoolean::class);
        Properties::registerProperty(TypeBoolean::class, 'bool');
        Properties::registerProperty(TypeDate::class);
        Properties::registerProperty(TypeDateTime::class);
        Properties::registerProperty(TypeEnum::class);
        Properties::registerProperty(TypeFloat::class);
        Properties::registerProperty(TypeInteger::class);
        Properties::registerProperty(TypeInteger::class,'int');
        Properties::registerProperty(TypeText::class);
        Properties::registerProperty(TypeTime::class);
        Properties::registerProperty(TypeVarchar::class);
        Properties::registerProperty(TypeVarchar::class,'string');
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
