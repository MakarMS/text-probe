<?php

namespace Tests\Probes\Identity\Passport;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\Passport\UsPassportNumberProbe;

/**
 * @internal
 */
class UsPassportNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UsPassportNumberProbe();

        $expected = '123456789';
        $text = 'Value: 123456789';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::US_PASSPORT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UsPassportNumberProbe();

        $expected = '123456789';
        $text = 'First 123456789 then 123456789';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::US_PASSPORT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::US_PASSPORT_NUMBER, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new UsPassportNumberProbe();

        $text = 'Value: 12345678';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new UsPassportNumberProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new UsPassportNumberProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
