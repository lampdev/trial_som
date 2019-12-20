<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Home extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url(): string
    {
        return '/home';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser): void
    {
        $browser->waitForLocation($this->url())->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements(): array
    {
        return [
            '@navbar-toggle' => '.navbar .navbar-toggler',
            '@navbar-dropdown-toggle' => '.navbar-nav.ml-auto .dropdown-toggle',
        ];
    }

    /**
     * Click on the log out link.
     *
     * @param  \Laravel\Dusk\Browser $browser
     * @return void
     */
    public function clickLogout($browser): void
    {
        $browser
            ->waitFor('.navbar-nav.ml-auto .dropdown-toggle')
            ->click('.navbar-nav.ml-auto .dropdown-toggle') // expand dropdown by clicking on toggle
            ->waitForText('Logout')
            ->clickLink('Logout')
            ->pause(100);
    }
}
