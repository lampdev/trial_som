<?php

namespace App\Services\Folder;

use App\Repositories\Folder\FolderRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;

class FolderService
{
    /** @var App\Repositories\Folder\FolderRepository*/
    private $folderRepository;

    /**
     * FolderService constructor.
     * @param FolderRepository $folderRepository
     */
    public function __construct(FolderRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    /**
     * @param array $params
     * @return Folder
     */
    public function create(array $params): Folder
    {
        $params['user_id'] = Auth::id();
        return $this->folderRepository->create($params);
    }

    /**
     * @return iterable
     */
    public function get(): iterable
    {
        return $this->folderRepository->getByUserId();
    }

    /**
     * @param array   $params
     * @param integer $id
     * @return Folder
     */
    public function update(array $params, int $id): Folder
    {
        return $this->folderRepository->update($id, $params, true);
    }

    /**
     * @param integer $id
     * @return Folder
     */
    public function delete(int $id): Folder
    {
        return $this->folderRepository->remove($id);
    }

    /**
     * @param integer $id
     * @return Folder
     */
    public function restore(int $id): Folder
    {
        return $this->folderRepository->restore($id);
    }

    /**
     * @param integer $id
     * @return iterable
     */
    public function getByParentId(int $id): iterable
    {
        return $this->folderRepository->getByParentId($id);
    }
}