<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Tests\Browser\Pages\Home;
use Tests\Browser\Pages\Register;

/**
 * Test case for Register page
 */
class RegisterTest extends DuskTestCase
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
     * Test of a new user registration
     * 
     * @return void
     */
    public function testRegisterWithValidData(): void
    {
        $this->browse(
            function ($browser) {
                $browser->visit(new Register)
                    ->submit(
                        [
                        'name' => 'Test User',
                        'email' => 'test@test.app',
                        'password' => 'password',
                        'password_confirmation' => 'password',
                        ]
                    )
                    ->assertPageIs(Home::class);
            }
        );
    }

    /**
     * Test of failing the registration with the same user data twice
     * 
     * @return void
     */
    public function testCanNotRegisterWithTheSameTwice(): void
    {
        $user = factory(User::class)->create();

        $this->browse(
            function ($browser) use ($user) {
                $browser->visit(new Register)
                    ->submit(
                        [
                        'name' => 'Test User',
                        'email' => $user->email,
                        'password' => 'password',
                        'password_confirmation' => 'password',
                        ]
                    )
                    ->assertSee('The email has already been taken.');
            }
        );
    }
}