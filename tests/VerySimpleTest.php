<?php

require "vendor/autoload.php";

use PHPUnit\Framework\TestCase;

class VerySimpleTest extends TestCase
{
    public function testIfTrueIsTrue()
    {
        $this->assertTrue(true);
    }
}