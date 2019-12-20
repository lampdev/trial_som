<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\{Folders, Folder, Login, Home};
use App\Models\Folder as FoldersModel;
use App\Models\User;

/**
 * Test case for Folders page
 */
class FoldersTest extends DuskTestCase
{
    protected $user;

    /**
     * Set up of the current test case
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setup();

        $this->user = factory(User::class)->create();

        static::closeAll();
    }

    /**
     * Test of creation of a new folder
     *
     * @return void
     */
    public function testCreateFolder(): void
    {
        $user = $this->user;

        $this->browse(
            function ($browser) use ($user) {
                $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->assertPageIs(Home::class)
                    ->visit(new Folders)
                    ->waitFor('.btn')
                    ->press('New Folder')
                    ->whenAvailable(
                        '.modal',
                        function ($modal) {
                            $modal->press('Close');
                        }
                    )
                    ->waitUntilMissing('.modal')
                    ->press('New Folder')
                    ->whenAvailable(
                        '.modal',
                        function ($modal) {
                            $modal->assertSee('Title')
                                ->type('title', 'Test')
                                ->press('Create Folder');
                        }
                    )
                    ->waitUntilMissing('.modal')
                    ->press('New Folder')
                    ->whenAvailable(
                        '.modal',
                        function ($modal) {
                            $modal->assertSee('Title')
                                ->type('title', 'Test')
                                ->press('Create Folder')
                                ->pause(1000)
                                ->assertSee('That folder name already exists')
                                ->press('Close');
                        }
                    )
                    ->waitUntilMissing('.modal')
                    ->whenAvailable(
                        '.alert',
                        function ($modal) {
                            $modal->assertSee('Your folder Test has been created');
                        }
                    )
                    ->waitUntilMissing('.alert');
            }
        );
    }

    /**
     * Test of showing all root folders
     *
     * @return void
     */
    public function testFoldersList(): void
    {
        $folder = FoldersModel::create(
            [
                'title' => 'Test 1',
                'parent_id' => 0,
                'user_id' => $this->user->id
            ]
        );

        $user = $this->user;

        $this->browse(
            function ($browser) use ($folder, $user) {
                $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->assertPageIs(Home::class)
                    ->visit(new Folders)
                    ->whenAvailable(
                        '.card',
                        function ($card) use ($folder) {
                            $card->assertSee('Test')
                                ->click('.card')
                                ->pause(1000)
                                ->assertPageIs(new Folder($folder->id));
                        }
                    );
            }
        );
    }

    /**
     * Test of creating of a New Folder
     *
     * @return void
     */
    public function testAddSubFolder(): void
    {
        $folder = FoldersModel::create(
            [
                'title' => 'Test 2',
                'parent_id' => 0,
                'user_id' => $this->user->id
            ]
        );

        $user = $this->user;



        $this->browse(
            function ($browser) use ($folder, $user) {
                $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->assertPageIs(Home::class)
                    ->visit(new Folder($folder->id))
                    ->press('New Folder')
                    ->whenAvailable(
                        '.modal',
                        function ($modal) {
                            $modal->press('Close');
                        }
                    )
                    ->waitUntilMissing('.modal')
                    ->press('New Folder')
                    ->whenAvailable(
                        '.modal',
                        function ($modal) {
                            $modal->assertSee('Title')
                                ->press('Create Folder')
                                ->pause(500)
                                ->assertSee('Please provide a folder name')
                                ->type('title', 'Test 3')
                                ->press('Create Folder');
                        }
                    )
                    ->waitUntilMissing('.modal')
                    ->press('New Folder')
                    ->whenAvailable(
                        '.modal',
                        function ($modal) {
                            $modal->assertSee('Title')
                                ->type('title', 'Test 3')
                                ->press('Create Folder')
                                ->pause(500)
                                ->assertSee('That folder name already exists')
                                ->press('Close');
                        }
                    )
                    ->waitUntilMissing('.modal')
                    ->whenAvailable(
                        '.alert',
                        function ($modal) {
                            $modal->assertSee('Your folder Test 3 has been created');
                        }
                    )
                    ->waitUntilMissing('.alert');
            }
        );
    }

    /**
     * Test of showing all sub folders
     *
     * @return void
     */
    public function testSubFoldersList(): void
    {
        $folder = FoldersModel::create(
            [
                'title' => 'Test 4',
                'parent_id' => 0,
                'user_id' => $this->user->id
            ]
        );

        $subFolder = FoldersModel::create(
            [
                'title' => 'Test 5',
                'parent_id' => $folder->id,
                'user_id' => $this->user->id
            ]
        );

        $user = $this->user;

        $this->browse(
            function ($browser) use ($folder, $subFolder, $user) {
                $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->assertPageIs(Home::class)
                    ->visit(new Folder($folder->id))
                    ->whenAvailable(
                        '.card',
                        function ($card) use ($subFolder) {
                            $card->assertSee('Test 5')
                                ->click('.card')
                                ->pause(500)
                                ->assertPageIs(new Folder($subFolder->id));
                        }
                    );
            }
        );
    }

    /**
     * Test of editing the folder
     *
     * @return void
     */
    public function testEditFolder(): void
    {
        $folder = FoldersModel::create(
            [
                'title' => 'Test 6',
                'parent_id' => 0,
                'user_id' => $this->user->id
            ]
        );

        $user = $this->user;

        $this->browse(
            function ($browser) use ($folder, $user) {
                $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->assertPageIs(Home::class)
                    ->visit(new Folders)
                    ->whenAvailable(
                        '.card',
                        function ($card) use ($folder, $browser) {
                            $card->assertSee('Test 6')
                                ->click('.btn.dropdown-toggle.btn-link.text-decoration-none.dropdown-toggle-no-caret')
                                ->pause(500)
                                ->whenAvailable(
                                    '.dropdown-menu',
                                    function ($dropdown) use ($folder, $browser) {
                                        $dropdown->click('li:nth-child(1) > a');
                                        $browser->whenAvailable(
                                            '.modal',
                                            function ($modal) {
                                                $modal->press('Close');
                                            }
                                        )
                                            ->waitUntilMissing('.modal');
                                    }
                                )
                                ->click('.btn.dropdown-toggle.btn-link.text-decoration-none.dropdown-toggle-no-caret')
                                ->pause(500)
                                ->whenAvailable(
                                    '.dropdown-menu',
                                    function ($dropdown) use ($folder, $browser) {
                                        $dropdown->click('li:nth-child(1) > a');
                                        $browser->whenAvailable(
                                            '.modal',
                                            function ($modal) use ($folder) {
                                                $modal->assertSee('Title')
                                                    ->assertInputValue(
                                                        'title',
                                                        $folder->title
                                                    )
                                                    ->type('title', 'Test 7')
                                                    ->press('Edit Folder');
                                            }
                                        )
                                            ->waitUntilMissing('.modal');
                                    }
                                )
                                ->assertSee('Test 7');
                        }
                    );
            }
        );
    }

    /**
     * Test of deleting the folder
     *
     * @return void
     */
    public function testDeleteFolder()
    {
        FoldersModel::create(
            [
                'title' => 'Test 8',
                'parent_id' => 0,
                'user_id' => $this->user->id
            ]
        );

        $user = $this->user;

        $this->browse(
            function ($browser) use ($user) {
                $browser
                    ->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->assertPageIs(Home::class)
                    ->visit(new Folders)
                    ->whenAvailable(
                        '.card',
                        function ($card) use ($browser) {
                            $card->assertSee('Test 8')
                                ->click('.btn.dropdown-toggle.btn-link.text-decoration-none.dropdown-toggle-no-caret')
                                ->pause(500)
                                ->whenAvailable(
                                    '.dropdown-menu',
                                    function ($dropdown) use ($browser) {
                                        $dropdown->click('li:nth-child(2) > a')
                                            ->pause(500);
                                        $browser->assertMissing('.card .card')
                                            ->whenAvailable(
                                                '.alert',
                                                function ($modal) {
                                                    $modal->assertSee('Your folder has been deleted')
                                                        ->assertSee('Undo')
                                                        ->press('Undo');
                                                }
                                            )
                                            ->waitUntilMissing('.alert')
                                            ->assertPresent('.card');
                                    }
                                );
                        }
                    );
            }
        );
    }
}
