<?php

namespace Tests\Probes\Identity;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\RussianPassportNumberProbe;

/**
 * @internal
 */
class RussianPassportNumberProbeTest extends TestCase
{
    public function testDetectsPassportWithSpaces(): void
    {
        $probe = new RussianPassportNumberProbe();

        $text = 'Passport 45 01 123456 issued.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertSame('45 01 123456', $results[0]->getResult());
        $this->assertSame(9, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUSSIAN_PASSPORT_NUMBER, $results[0]->getProbeType());
    }

    public function testDetectsPassportWithHyphens(): void
    {
        $probe = new RussianPassportNumberProbe();

        $text = 'Doc: 11-22-333444 check.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertSame('11-22-333444', $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUSSIAN_PASSPORT_NUMBER, $results[0]->getProbeType());
    }

    public function testDetectsPassportWithoutSeparators(): void
    {
        $probe = new RussianPassportNumberProbe();

        $text = 'ID4501123456embedded';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertSame('4501123456', $results[0]->getResult());
        $this->assertSame(2, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUSSIAN_PASSPORT_NUMBER, $results[0]->getProbeType());
    }

    public function testRejectsInvalidRegion(): void
    {
        $probe = new RussianPassportNumberProbe();

        $text = 'Invalid 00 12 345678 sample';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testMultiplePassportsDetected(): void
    {
        $probe = new RussianPassportNumberProbe();

        $text = 'Passports: 45 01 123456, 77 09 654321.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame('45 01 123456', $results[0]->getResult());
        $this->assertSame(11, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUSSIAN_PASSPORT_NUMBER, $results[0]->getProbeType());

        $this->assertSame('77 09 654321', $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::RUSSIAN_PASSPORT_NUMBER, $results[1]->getProbeType());
    }

    public function testRejectsTooShortNumber(): void
    {
        $probe = new RussianPassportNumberProbe();

        $text = 'Numbers like 12 34 5678 are too short to be passports.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }
}
