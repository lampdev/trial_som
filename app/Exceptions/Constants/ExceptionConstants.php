<?php

namespace App\Constants;

/**
 * Interface ExceptionConstants
 * This should be updated any time a new exception type is created!!
 *
 * @package App\Libraries\Constants
 */
interface ExceptionConstants
{
    // user exceptions
    public const USER_NOT_FOUND_EXCEPTION = 1000;
    public const USER_INVALID_ACCESS_EXCEPTION = 1001;
    public const USER_INVALID_ACTION_EXCEPTION = 1002;

    // entity exceptions
    public const ENTITY_NOT_FOUND_EXCEPTION = 2000;

    // validation exceptions
    public const GRIDPANE_VALIDATION_EXCEPTION = 3000;

    // database exceptions
    public const DB_REQUEST_EXCEPTION = 5000;

    // general exceptions
    public const GRIDPANE_GENERAL_EXCEPTION = 9000;
}
