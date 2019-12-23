<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/5/19
 * Time: 17:46
 */

namespace App\Exceptions;

use App\Constants\ExceptionConstants;
use App\Constants\HttpConstants;
use App\Http\Resources\ErrorResource;
use Exception;

class UpdateException extends Exception
{
    /**
     * UpdateException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     *  Render the exception into an HTTP response.
     * @param $request
     * @return ErrorResource
     */
    public function render($request)
    {
        // TODO dump to log: $this->message, HttpConstants::HTTP_SERVER_ERROR, ExceptionConstants::DB_REQUEST_EXCEPTION
        return (new ErrorResource((object) [
            'message' => $this->message,
            'httpCode' => HttpConstants::HTTP_SERVER_ERROR,
            'internalCode' => ExceptionConstants::DB_REQUEST_EXCEPTION
        ]))->response()->setStatusCode(HttpConstants::HTTP_SERVER_ERROR);
    }
}
