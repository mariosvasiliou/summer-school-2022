<?php

namespace App\Exceptions;

use Exception;

class ContactIsUserException extends Exception
{
    protected $message = 'Contact is user cannot be deleted';
}
