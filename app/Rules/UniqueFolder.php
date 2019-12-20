<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\Folder\FolderRepository;
use Illuminate\Support\Facades\Auth;

class UniqueFolder implements Rule
{
    /** @var App\Repositories\Folder\FolderRepository*/
    private $folderRepository;

    /**
     * FolderRepository $folderRepository
     *
     * @return void
     */
    public function __construct(FolderRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $item = $this->folderRepository->getByUserIdAndParentId(request()->get('id'), Auth::id(), request()->get('parent_id'), $value);
        if (!empty($item)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'That folder name already exists';
    }
}
