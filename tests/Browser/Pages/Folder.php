<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * Folder Dusk Page
 */
class Folder extends Page
{
    /**
     * @var int Id of the current folder
     * */
    protected $folder_id;
 
    /**
     * Construct
     * 
     * @param int $folder_id Id of the current folder
     */
    public function __construct(int $folder_id)
    {
        $this->folder_id = $folder_id;
    }    

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url(): string
    {
        return '/folders/' . $this->folder_id;
    }
}