<?php

/**
 * RequestEntityTooLargeException
 *
 */
class RequestEntityTooLargeException extends HttpException {

    public function __construct($message = null, $code = 413) {
        if (empty($message)) {
            $message = __('Request Entity Too Large Error.');
        }
        parent::__construct($message, $code);
    }
}