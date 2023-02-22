<?php

use PHPUnit\Framework\TestCase;
use Seb\App\Validator\EmailValidator;

require "vendor/autoload.php";

class EmailValidatorTest extends TestCase
{
    private EmailValidator $validator;

    /**
     * Exécution de cette méthode avant chaque
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->validator = new EmailValidator;
    }

    public function getProviders()
    {
        return [
            ["moi@moi.com", true],
            ["lui @lui.com", false],
            ["emailsansarobase.com", false],
            ["1111@222.33", false]
        ];
    }

    /**
     * @dataProvider getProviders
     * 
     *
     * @param [type] $input
     * @param [type] $expected
     * @return void
     */
    public function testWithProviders($input, $expected)
    {
        $value = $this->validator->validate($input);
        $this->assertEquals($expected, $value);
    }

    public function testIfNullValueReturnsAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $val = $this->validator->validate(null);
    }

    public function testIfEmptyValueReturnsAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $val = $this->validator->validate("");
    }
}