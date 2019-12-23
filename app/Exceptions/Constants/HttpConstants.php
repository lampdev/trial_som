<?php

namespace App\Constants;

/**
 * Interface HttpConstants
 *
 * @package App\Libraries\Constants
 */
interface HttpConstants
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_INVALID_REQUEST = 422;
    public const HTTP_SERVER_ERROR = 500;
    public const HTTP_NOT_IMPLEMENTED = 501; // technically this is for HTTP methods
}
