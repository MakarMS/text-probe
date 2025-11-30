<?php

namespace Tests\Probes\Contact;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\PhoneProbe;

/**
 * @internal
 */
class PhoneProbeTest extends TestCase
{
    public function testSinglePhoneFound(): void
    {
        $probe = new PhoneProbe();

        $text = 'Call me at +7 (495) 123-45-67';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('+7 (495) 123-45-67', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());
    }

    public function testMultiplePhonesFound(): void
    {
        $probe = new PhoneProbe();

        $text = 'Hotlines: +7 999 555 44 33, 8-800-200-00-00';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('+7 999 555 44 33', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());

        $this->assertEquals('8-800-200-00-00', $results[1]->getResult());
        $this->assertEquals(28, $results[1]->getStart());
        $this->assertEquals(43, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[1]->getProbeType());
    }

    public function testPhoneWithoutCountryCode(): void
    {
        $probe = new PhoneProbe();

        $text = 'Local: (812)1234567';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals('(812)1234567', $results[0]->getResult());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());
    }

    public function testPhoneWithDifferentDelimiters(): void
    {
        $probe = new PhoneProbe();

        $text = 'Number: 123 456-78-90 and 123-456 78 90';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('123 456-78-90', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(21, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());

        $this->assertEquals('123-456 78 90', $results[1]->getResult());
        $this->assertEquals(26, $results[1]->getStart());
        $this->assertEquals(39, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[1]->getProbeType());
    }

    public function testNoPhoneFound(): void
    {
        $probe = new PhoneProbe();

        $text = 'No phones here, just words and numbers like 12345';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testPhoneAtStartAndEnd(): void
    {
        $probe = new PhoneProbe();

        $text = '+7 123 456 78 90 is my number and another is 8-800-555-35-35';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('+7 123 456 78 90', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());

        $this->assertEquals('8-800-555-35-35', $results[1]->getResult());
        $this->assertEquals(45, $results[1]->getStart());
        $this->assertEquals(60, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[1]->getProbeType());
    }

    public function testPhoneNearPunctuation(): void
    {
        $probe = new PhoneProbe();

        $text = 'Can you call +7-999-123-45-67? Thanks.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('+7-999-123-45-67', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());
    }

    public function testPhoneWithMinimalDigits(): void
    {
        $probe = new PhoneProbe();

        $text = 'Try 123-4567 or 1234567';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('123-4567', $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());

        $this->assertEquals('1234567', $results[1]->getResult());
        $this->assertEquals(16, $results[1]->getStart());
        $this->assertEquals(23, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[1]->getProbeType());
    }

    public function testMixedValidAndInvalidPhones(): void
    {
        $probe = new PhoneProbe();

        $text = 'Wrong: 123-45. Right: +1 (202) 555-0173';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('+1 (202) 555-0173', $results[0]->getResult());
        $this->assertEquals(22, $results[0]->getStart());
        $this->assertEquals(39, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PHONE, $results[0]->getProbeType());
    }
}
