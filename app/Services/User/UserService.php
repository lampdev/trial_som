<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/4/19
 * Time: 17:23
 */

namespace App\Services\User;

use App\Exceptions\UpdateException;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;
use App\Services\AbstractService;

class UserService extends AbstractService implements UserServiceInterface
{
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new user instance.
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->create($data);
    }

    /**
     * Create a new user instance.
     * @param int $userId
     * @param array $data
     * @return mixed
     */
    public function update(int $userId, array $data)
    {
        $user = $this->userRepository->update($userId, $data, true);
        return new UserResource($user);
    }

    public function changePassword(int $userId, string $password)
    {
        $newPassword = bcrypt($password);
        $user = $this->userRepository->update($userId, [
            'password' => $newPassword
        ], true);
        if ($newPassword !== $user->password) {
            throw new UpdateException('Password wasn\'t changed');
        }

        return new UserResource($user);
    }
}
