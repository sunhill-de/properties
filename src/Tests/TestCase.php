<?php

namespace Sunhill\Properties\Tests;

use Sunhill\Basic\Tests\SunhillOrchestraTestCase;
use Sunhill\Basic\Tests\SunhillTestCase;
use Sunhill\Basic\SunhillBasicServiceProvider;
use Sunhill\Properties\SunhillServiceProvider;

class TestCase extends SunhillOrchestraTestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }
    
    protected function getPackageProviders($app)
    {
        return [
            SunhillBasicServiceProvider::class,
            SunhillServiceProvider::class,
         ];
    }
    
}