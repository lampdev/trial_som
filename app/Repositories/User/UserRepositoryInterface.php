<?php

namespace App\Repositories\User;

use App\Repositories\AbstractInterface;

interface UserRepositoryInterface extends AbstractInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);
}
