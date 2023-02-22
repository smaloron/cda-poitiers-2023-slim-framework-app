<?php

use PHPUnit\Framework\TestCase;
use Seb\App\Validator\EmailValidator;

require "vendor/autoload.php";

class EmailValidatorTest extends TestCase
{

    public function testIfNullValueReturnsAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $validator = new EmailValidator;
        $val = $validator->validate(null);
    }
}