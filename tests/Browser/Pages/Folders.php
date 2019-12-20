<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * Folders Dusk Page
 */
class Folders extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url(): string
    {
        return '/folders';
    }
}