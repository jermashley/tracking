<?php

namespace Tests\Browser;

use Illuminate\Support\Sleep;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/testing/oauth-login')
                ->assertPathIs('/admin/dashboard');
            $browser->waitFor('h1')->assertSee('Companies');
            Sleep::for(10)->seconds();
        });
    }
}
