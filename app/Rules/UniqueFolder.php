<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\Folder\FolderService;

class UniqueFolder implements Rule
{
    /** @var \App\Services\Folder\FolderService*/
    private $folderService;

    /**
     * FolderService $folderService
     *
     * @return void
     */
    public function __construct(FolderService $folderService)
    {
        $this->folderService = $folderService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $item = $this->folderService->getByUserIdAndParentId(
            request()->get('id'),
            request()->get('parent_id'),
            $value
        );

        return empty($item);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'That folder name already exists';
    }
}
