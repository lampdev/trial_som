<?php

namespace App\Repositories\User;

use App\Repositories\AbstractRepository;
use App\Models\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
