<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\UpdatePassword;
use App\Http\Controllers\Controller;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    private $userService;
    /**
     * ProfileController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Update the user's password.
     *
     * PhanUndeclaredConstant
     *
     * @param UpdatePassword $request
     * @return mixed
     */
    public function update(UpdatePassword $request)
    {
        return $this->userService->changePassword(Auth::id(), $request->password);
    }
}
