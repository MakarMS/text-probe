<?php

namespace Tests\Probes\Finance;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\RussianOgrnNumberProbe;

/**
 * @internal
 */
class RussianOgrnNumberProbeTest extends TestCase
{
    public function testFindsValidOgrn(): void
    {
        $probe = new RussianOgrnNumberProbe();

        $text = 'OGRN: 1027700132195 registered';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('1027700132195', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::RUSSIAN_OGRN_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidChecksum(): void
    {
        $probe = new RussianOgrnNumberProbe();

        $results = $probe->probe('OGRN: 1027700132194');

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleOgrnNumbers(): void
    {
        $probe = new RussianOgrnNumberProbe();

        $text = 'First 1027700132195 and 5000000000006';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('1027700132195', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::RUSSIAN_OGRN_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('5000000000006', $results[1]->getResult());
        $this->assertEquals(24, $results[1]->getStart());
        $this->assertEquals(37, $results[1]->getEnd());
        $this->assertEquals(ProbeType::RUSSIAN_OGRN_NUMBER, $results[1]->getProbeType());
    }

    public function testIgnoresWrongLength(): void
    {
        $probe = new RussianOgrnNumberProbe();

        $results = $probe->probe('Short 123456789012');

        $this->assertCount(0, $results);
    }

    public function testEmptyStringIsInvalid(): void
    {
        $probe = new RussianOgrnNumberProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }
}
