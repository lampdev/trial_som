<?php

namespace App\Repositories\Folder;

use App\Repositories\AbstractRepository;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class FolderRepository extends AbstractRepository
{
    /**
     * FolderRepository constructor.
     * @param Folder $folder
     */
    public function __construct(Folder $folder)
    {
        $this->model = $folder;
    }

    /**
     * @param integer $id
     * @return Folder
     */
    public function restore(int $id): Folder
    {
        $this->model->where('id', $id)->restore();
        $item = $this->model->find($id);
        return $item;
    }

    /**
     * @param integer $id
     * @return iterable
     */
    public function getByParentId($id): iterable
    {
        return $this->model->where([['user_id', Auth::id()], ['parent_id', $id]])->get();
    }

    /**
     * @return mixed
     */
    public function getByUserId()
    {
        return $this->model->select()
            ->where([['user_id', Auth::id()], ['parent_id', 0]])
            ->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param integer $id
     * @param integer $user_id
     * @param integer $parent_id
     * @param string  $title
     * @return integer
     */
    public function getByUserIdAndParentId(int $id, int $user_id, int $parent_id, string $title): ?int
    {
        return $this->model->where([
            ['user_id', $user_id],
            ['parent_id', $parent_id],
            ['title', $title],
            ['id', '<>', $id]
        ])->value('id');
    }
}
