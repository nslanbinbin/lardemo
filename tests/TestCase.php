<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

 class TestCase extends BaseTestCase
{


     /**
      * The base URL to use while testing the application.
      * @var string
      */
     protected $baseUrl = 'http://localhost:8888/lar/public/';

     public function setUp()
     {
         parent::setUp();
     }

     /**
      * Creates the application.
      *
      * @return \Illuminate\Foundation\Application
      */
     public function createApplication()
     {
         $app = require __DIR__.'/../bootstrap/app.php';
         $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
         return $app;
     }
}
