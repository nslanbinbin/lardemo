<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $array = array();
        $array['price0'] = 3;
        $array['price1'] = 4;


        $this->json('POST', '/index/getdata', $array);
    }

    public function test最小价格位数是否是整数(){
        $array = array();
        $array['price0'] = '3';
        $array['price1'] = 4;

        $this->postJson('/index/getdata', $array);
        $this->assertTrue(false,'price0必须为整数');
    }

    public function test最大价格位数是否是整数(){
        $array = array();
        $array['price0'] = 3;
        $array['price1'] = 4.5;

        $this->postJson('/index/getdata', $array);
        $this->assertTrue(false,'price1必须为整数');
    }
}
