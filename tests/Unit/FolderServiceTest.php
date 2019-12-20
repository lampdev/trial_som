<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Folder\FolderService;
use App\Models\User;
use App\Models\Folder;

/**
 * Unit test case for FolderService class
 */
class FolderServiceTest extends TestCase
{
    /**
     * Instance of the Folder Service
     * 
     * @var FolderService
     */
    protected $folderService;

    /**
     * Instance of the fake user
     * 
     * @var User
     */
    protected $user;

    /**
     * Test data for a new folder
     * 
     * @var array
     */
    protected $testFolder;

    /**
     * Set up of the current test case
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->folderService = resolve(FolderService::class);

        $this->user = factory('App\Models\User')->create();

        $this->testFolder = [
            'title' => 'Test Test',
            'parent_id' => 0,
            'user_id' => $this->user->id
        ];
    }

    /**
     * Test the create method
     * 
     * @return void
     */
    public function testCreate(): void
    {
        $this->be($this->user);

        $folder = $this->folderService->create($this->testFolder);

        $this->assertInstanceOf(Folder::class, $folder);
        $this->assertEquals(
            $this->testFolder,
            [
                'title' => $folder->title,
                'parent_id' => $folder->parent_id,
                'user_id' => $folder->user_id
            ]
        );


        $this->assertDatabaseHas('folders', $this->testFolder);
    }

    /**
     * Test the retreaving of list the folders
     * 
     * @return void
     */
    public function testGet(): void
    {
        $this->be($this->user);

        $folder = $this->folderService->create($this->testFolder);
        $folders = $this->folderService->get();

        $this->assertContainsOnlyInstancesOf(Folder::class, $folders->all());
        $this->assertContains($folder->toArray(), $folders->toArray());
    }

    /**
     * Test the editing of the folder
     * 
     * @return void
     */
    public function testUpdate(): void
    {
        $this->be($this->user);

        $folder = $this->folderService->create($this->testFolder);
        $updatedFolder = $this->folderService->update(
            [
                'parent_id' => 0,
                'user_id' => $this->user->id,
                'title' => 'Test 123'
            ],
            $folder->id
        );

        $this->assertDatabaseHas(
            'folders',
            [
                'title' => $updatedFolder->title,
                'parent_id' => $this->testFolder['parent_id'],
                'user_id' => $this->testFolder['user_id']
            ]
        );

        $this->assertInstanceOf(Folder::class, $updatedFolder);
        $this->assertNotEquals($folder, $updatedFolder);
        $this->assertEquals($updatedFolder->title, 'Test 123');
    }

    /**
     * Test the deliting of the folder
     * 
     * @return void
     */
    public function testDelete(): void
    {
        $this->be($this->user);

        $folder = $this->folderService->create($this->testFolder);
        $removedFolder = $this->folderService->delete($folder->id);

        $this->assertInstanceOf(Folder::class, $removedFolder);
        $this->assertEquals($folder->id, $removedFolder->id);
        $this->assertDatabaseMissing('folders', $folder->toArray());
    }

    /**
     * Test the restore of the deleted folder
     * 
     * @return void
     */
    public function testRestore(): void
    {
        $this->be($this->user);

        $folder = $this->folderService->create($this->testFolder);
        $this->folderService->delete($folder->id);
        $restoredFolder = $this->folderService->restore($folder->id);

        $this->assertInstanceOf(Folder::class, $restoredFolder);
        $this->assertEquals($folder, $restoredFolder);
        $this->assertDatabaseHas('folders', $folder->toArray());
    }

    /**
     * Test the getting of the subfolders method
     * 
     * @return void
     */
    public function testGetByParentId(): void
    {
        $this->be($this->user);

        $folder = $this->folderService->create($this->testFolder);
        $subfolder = $this->folderService->create(
            [
                'title' => 'Test Sub',
                'parent_id' => $folder->id
            ]
        );
        $subfolders = $this->folderService->getByParentId($folder->id);

        $this->assertContainsOnlyInstancesOf(Folder::class, $subfolders->all());
        $this->assertContains($subfolder->toArray(), $subfolders->toArray());
    }
}
