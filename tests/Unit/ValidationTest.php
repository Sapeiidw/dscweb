<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

class ValidationTest extends TestCase
{

    public function test_email_validation()
    {
        $words = 'email@eaxample.com';
        $this->assertTrue(Str::containsAll($words, ['@','.']),'valid');
        $this->assertNotNull($words);
    }

    public function test_password_validation()
    {
        $words = 'Minimal8';
        $this->assertIsString($words);
        $this->assertNotNull($words);
    }
}
