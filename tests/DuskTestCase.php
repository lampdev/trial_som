<?php

namespace Tests;

use Laravel\Dusk\Page;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// The Dusk macro to determine the current page is what we need.
Browser::macro(
    'assertPageIs',
    function ($page) {
        if (!$page instanceof Page) {
            $page = new $page;
        }
        // waiting for location before asserting,
        // because window.location.pathname may be updated asynchronously
        return $this->waitForLocation($page->url())->assertPathIs($page->url());
    }
);

/**
 * Abstract implementation of the DUSK test case
 */
abstract class DuskTestCase extends BaseTestCase
{
    use DatabaseMigrations;
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return      void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(
            [
                '--disable-gpu',
                '--headless',
                '--no-sandbox',
                '--ignore-ssl-errors',
                '--whitelisted-ips=""',
                '--window-size=1920,1080'
            ]
        );

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }
}
