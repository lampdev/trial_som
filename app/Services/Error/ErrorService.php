<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/4/19
 * Time: 17:23
 */

namespace App\Services\Error;

use App\Http\Resources\ErrorResource;
use App\Services\AbstractService;

class ErrorService extends AbstractService implements ErrorServiceInterface
{
    /**
     * ErrorService constructor.
     */
    public function __construct()
    {
    }
    public function push($request)
    {
        return new ErrorResource($request);
    }
}
