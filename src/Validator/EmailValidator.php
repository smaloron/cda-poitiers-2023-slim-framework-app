<?php

namespace Seb\App\Validator;

use InvalidArgumentException;

class EmailValidator
{

    public function validate($value)
    {
        if ($value == null) {
            throw new InvalidArgumentException("L'adresse email ne peut être nulle");
        }
        $email = filter_var($value, FILTER_VALIDATE_EMAIL);
        return $email != null;
    }
}