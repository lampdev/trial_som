<?php

namespace Tests\Browser\Pages;

/**
 * Login Dusk Page
 */
class Login extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url(): string
    {
        return '/login';
    }

    /**
     * Submit the form with the given credentials.
     *
     * @param \Laravel\Dusk\Browser $browser  Instance of the DUSK browser
     * @param string                $email    User`s email
     * @param string                $password User`s password
     *
     * @return void
     */
    public function submit($browser, $email, $password): void
    {
        $browser->type('email', $email)
            ->type('password', $password)
            ->press('Log In')
            ->pause(1000);
    }
}
