<?php

namespace Tests\Validator;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\NoopValidator;

class NoopValidatorTest extends TestCase
{
    public function testNoopValidatorAlwaysTrue(): void
    {
        $validator = new NoopValidator();
        $this->assertTrue($validator->validate('1234567890-='));
    }
}
