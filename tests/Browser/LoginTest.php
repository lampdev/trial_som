<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Tests\Browser\Pages\Home;
use Tests\Browser\Pages\Login;

/**
 * Test case for Login page
 */
class LoginTest extends DuskTestCase
{
    /**
     * Set up of the current test case
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setup();

        static::closeAll();
    }

    /**
     * Test for succesfull login
     *
     * @return void
     */
    public function testLoginWithValidCredentials(): void
    {
        $user = factory(User::class)->create();

        $this->browse(
            function ($browser) use ($user) {
                $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->assertPageIs(Home::class);
            }
        );
    }

    /**
     * Test login with invalid credentials
     *
     * @return void
     */
    public function testLoginWithInvalidCredentials(): void
    {
        $this->browse(
            function ($browser) {
                $browser->visit(new Login)
                    ->submit('test@test.app', 'password')
                    ->assertSee('These credentials do not match our records.');
            }
        );
    }

    /**
     * Test logout of user
     *
     * @return void
     */
    public function testLogOutTheUser(): void
    {
        $user = factory(User::class)->create();

        $this->browse(
            function ($browser) use ($user) {
                $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->on(new Home)
                    ->clickLogout($user->name)
                    ->assertPageIs(Login::class);
            }
        );
    }
}
