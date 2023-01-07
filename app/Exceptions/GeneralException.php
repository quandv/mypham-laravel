<?php

namespace App\Exceptions;

use Exception;

/**
 * Class GeneralException
 * @package App\Exceptions
 */
class GeneralException extends Exception {
	/**
     * Class constructor
     *
     * @param string $message Error message
     * @param int $code       Error code
     */
    function __construct($message = null, $code = 0)
    {
        parent::__construct($message, $code);
    }
}