<?php

namespace Sunhill\Properties\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sunhill\Basic\SunhillBasicServiceProvider;
use Sunhill\Properties\SunhillPropertiesServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            SunhillBasicServiceProvider::class,
            SunhillPropertiesServiceProvider::class,            
        ];        
    }
        //
}
