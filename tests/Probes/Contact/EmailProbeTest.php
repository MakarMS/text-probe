<?php

namespace Tests\Probes\Contact;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\EmailProbe;

class EmailProbeTest extends TestCase
{
    public function testSingleEmailFound(): void
    {
        $probe = new EmailProbe();

        $text = 'Contact me at test@example.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('test@example.com', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(30, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());
    }

    public function testMultipleEmailsFound(): void
    {
        $probe = new EmailProbe();

        $text = 'Emails: one@example.com, two@example.org';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('one@example.com', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());

        $this->assertEquals('two@example.org', $results[1]->getResult());
        $this->assertEquals(25, $results[1]->getStart());
        $this->assertEquals(40, $results[1]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[1]->getProbeType());
    }

    public function testNoEmailsFound(): void
    {
        $probe = new EmailProbe();

        $text = 'This text has no email';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testEmailAtStartOfString(): void
    {
        $probe = new EmailProbe();
        $text = 'start@example.com is the address.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('start@example.com', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());
    }

    public function testEmailAtEndOfString(): void
    {
        $probe = new EmailProbe();

        $text = 'Contact me: end@example.org';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('end@example.org', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());
    }

    public function testEmailWithPlusSign(): void
    {
        $probe = new EmailProbe();

        $text = 'Send to dev+test@example.com please';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('dev+test@example.com', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());
    }

    public function testEmailWithSubdomain(): void
    {
        $probe = new EmailProbe();

        $text = 'admin@support.mail.co.uk';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('admin@support.mail.co.uk', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(24, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());
    }

    public function testDuplicateEmails(): void
    {
        $probe = new EmailProbe();

        $text = 'Email me at repeat@example.com or repeat@example.com again.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('repeat@example.com', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(30, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());

        $this->assertEquals('repeat@example.com', $results[1]->getResult());
        $this->assertEquals(34, $results[1]->getStart());
        $this->assertEquals(52, $results[1]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[1]->getProbeType());
    }

    public function testEmailSurroundedByPunctuation(): void
    {
        $probe = new EmailProbe();

        $text = 'Is this valid: test@example.com?';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('test@example.com', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::EMAIL, $results[0]->getProbeType());
    }

    public function testTextWithFakeEmail(): void
    {
        $probe = new EmailProbe();

        $text = 'This is not an email: just@somewords';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }
}
