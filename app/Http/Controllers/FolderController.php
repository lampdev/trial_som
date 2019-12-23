<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Folder\FolderService;
use App\Http\Resources\Folder\FolderResource;
use App\Http\Resources\Folder\FolderListResource;
use App\Http\Requests\FolderRequest;

class FolderController extends Controller
{
    /** @var \App\Services\Folder\FolderService*/
    private $folderService;

    /**
     * FolderController constructor.
     * @param FolderService $folderService
     */
    public function __construct(FolderService $folderService)
    {
        $this->folderService = $folderService;
    }

    /**
     * @param FolderRequest $request
     * @return FolderResource
     */
    public function create(FolderRequest $request): FolderResource
    {
        $params = $request->validated();
        return new FolderResource($this->folderService->create($params));
    }

    /**
     * @return FolderListResource
     */
    public function get(): FolderListResource
    {
        return new FolderListResource($this->folderService->get());
    }

    /**
     * @param FolderRequest $request
     * @return FolderResource
     */
    public function update(FolderRequest $request): FolderResource
    {
        $params = $request->validated();
        $id = $request->folder_id;
        return new FolderResource($this->folderService->update($params, $id));
    }

    /**
     * @param FolderRequest $request
     * @return FolderResource
     */
    public function delete(Request $request): FolderResource
    {
        $id = $request->folder_id;
        return new FolderResource($this->folderService->delete($id));
    }

    /**
     * @param Request $request
     * @return FolderResource
     */
    public function restore(Request $request): FolderResource
    {
        $id = $request->folder_id;
        return new FolderResource($this->folderService->restore($id));
    }

    /**
     * @param Request $request
     * @return FolderListResource
     */
    public function getByParentId(Request $request)
    {
        $id = $request->folder_id;
        return new FolderListResource($this->folderService->getByParentId($id));
    }
}
