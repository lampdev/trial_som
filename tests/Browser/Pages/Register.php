<?php

namespace Tests\Browser\Pages;

/**
 * Register Dusk Page
 */
class Register extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/register';
    }

    /**
     * Submit the form with the given data.
     *
     * @param \Laravel\Dusk\Browser $browser Instance of the DUSK browser
     * @param array                 $data    Register form data
     * 
     * @return void
     */
    public function submit($browser, array $data = [])
    {
        foreach ($data as $key => $value) {
            $browser->type($key, $value);
        }

        $browser->press('Register')
            ->pause(1000);
    }
}