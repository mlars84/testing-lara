<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';
    protected $user;

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

    // creating user for multiple test classes
    public function signIn($user = null)
    {
        if (! $user) {
            $user = factory(App\User::class)->create();
        }

        $this->user = $user;

        $hits->actingAs($this->user);

        return $this;
    }
}
