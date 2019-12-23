<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\UpdateProfile;
use App\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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
     * Update the user's profile information.
     *
     * @suppress PhanUndeclaredMethod
     *
     * @param UpdateProfile $request
     * @return mixed
     */
    public function update(UpdateProfile $request)
    {
        return $this->userService->update(Auth::id(), $request->only('name', 'email'));
    }
}
