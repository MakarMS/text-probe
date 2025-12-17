<?php

namespace Tests\Probes\Identity;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\RussianSnilsProbe;

/**
 * @internal
 */
class RussianSnilsProbeTest extends TestCase
{
    public function testFindsFormattedSnils(): void
    {
        $probe = new RussianSnilsProbe();

        $text = 'Valid SNILS: 112-233-445 95';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('112-233-445 95', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::RUSSIAN_SNILS, $results[0]->getProbeType());
    }

    public function testFindsCompactSnils(): void
    {
        $probe = new RussianSnilsProbe();

        $text = 'SNILS 11223344595 is compact';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('11223344595', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::RUSSIAN_SNILS, $results[0]->getProbeType());
    }

    public function testRejectsInvalidChecksum(): void
    {
        $probe = new RussianSnilsProbe();

        $text = 'Bad SNILS: 112-233-445 94';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleSnilsNumbers(): void
    {
        $probe = new RussianSnilsProbe();

        $text = 'List: 11223344595, 901-144-044 41';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('11223344595', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::RUSSIAN_SNILS, $results[0]->getProbeType());

        $this->assertEquals('901-144-044 41', $results[1]->getResult());
        $this->assertEquals(19, $results[1]->getStart());
        $this->assertEquals(33, $results[1]->getEnd());
        $this->assertEquals(ProbeType::RUSSIAN_SNILS, $results[1]->getProbeType());
    }

    public function testRejectsAllZeroSnils(): void
    {
        $probe = new RussianSnilsProbe();

        $text = 'Zeros: 000-000-000 00';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
