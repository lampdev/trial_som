<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

/**
 * Abstract implementation of the DUSK page
 */
abstract class Page extends BasePage
{
    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser Instance of the DUSK browser
     * 
     * @return void
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }
}