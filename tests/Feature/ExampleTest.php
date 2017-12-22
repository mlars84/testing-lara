<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        // visit the home page
        $this->visit('/')
             ->click('Click Me')
             ->see('You\'ve been clicked, punk.')
             ->seePageIs('/feedback');
    }
}
