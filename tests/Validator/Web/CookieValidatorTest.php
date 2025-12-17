<?php

namespace Tests\Validator\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Web\CookieValidator;

/**
 * @internal
 */
class CookieValidatorTest extends TestCase
{
    public function testValidSimpleCookiePair(): void
    {
        $validator = new CookieValidator();

        $this->assertTrue($validator->validate('sessionid=abc123'));
    }

    public function testValidCookieWithSetCookiePrefix(): void
    {
        $validator = new CookieValidator();

        $this->assertTrue($validator->validate('Set-Cookie: sessionid=abc123'));
    }

    public function testValidCookieWithCookiePrefix(): void
    {
        $validator = new CookieValidator();

        $this->assertTrue($validator->validate('Cookie: sessionid=abc123'));
    }

    public function testValidQuotedCookieValue(): void
    {
        $validator = new CookieValidator();

        $this->assertTrue($validator->validate('token="abc.def-123"'));
    }

    public function testRejectsForbiddenAttributeNames(): void
    {
        $validator = new CookieValidator();

        $this->assertFalse($validator->validate('Path=/'));
        $this->assertFalse($validator->validate('Expires=Wed, 21 Oct 2015 07:28:00 GMT'));
        $this->assertFalse($validator->validate('Max-Age=3600'));
        $this->assertFalse($validator->validate('Domain=example.com'));
        $this->assertFalse($validator->validate('SameSite=Lax'));
        $this->assertFalse($validator->validate('Secure=true'));
        $this->assertFalse($validator->validate('HttpOnly=true'));
        $this->assertFalse($validator->validate('Priority=High'));
    }

    public function testRejectsEmptyValue(): void
    {
        $validator = new CookieValidator();

        $this->assertFalse($validator->validate('sid='));
        $this->assertFalse($validator->validate('sid=""'));
        $this->assertFalse($validator->validate('sid="   "'));
    }

    public function testRejectsMalformedPairs(): void
    {
        $validator = new CookieValidator();

        $this->assertFalse($validator->validate('justtext'));
        $this->assertFalse($validator->validate('=value'));
        $this->assertFalse($validator->validate('name value'));
    }

    public function testTrimsInputBeforeValidation(): void
    {
        $validator = new CookieValidator();

        $this->assertTrue($validator->validate('  sessionid=abc123  '));
    }
}
