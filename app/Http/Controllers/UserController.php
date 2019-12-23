<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return User
     */
    public function getUser(Request $request): User
    {
        return $request->user();
    }
}
