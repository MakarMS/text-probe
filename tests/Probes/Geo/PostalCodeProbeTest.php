<?php

namespace Tests\Probes\Geo;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Geo\PostalCodeProbe;

/**
 * @internal
 */
class PostalCodeProbeTest extends TestCase
{
    public function testFindsRussianPostalCode(): void
    {
        $probe = new PostalCodeProbe();

        $text = 'Address: 123456 Moscow';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('123456', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::POSTAL_CODE, $results[0]->getProbeType());
    }

    public function testFindsUsZipPlusFour(): void
    {
        $probe = new PostalCodeProbe();

        $text = 'ZIP here: 10001-0001 is Manhattan';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('10001-0001', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::POSTAL_CODE, $results[0]->getProbeType());
    }

    public function testFindsUkPostalCode(): void
    {
        $probe = new PostalCodeProbe();

        $text = 'UK code SW1A 1AA near palace';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('SW1A 1AA', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::POSTAL_CODE, $results[0]->getProbeType());
    }

    public function testFindsCanadianPostalCodeWithHyphen(): void
    {
        $probe = new PostalCodeProbe();

        $text = 'Ottawa K1A-0B1 center';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('K1A-0B1', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(14, $results[0]->getEnd());
        $this->assertEquals(ProbeType::POSTAL_CODE, $results[0]->getProbeType());
    }

    public function testFindsDutchPostalCodeWithoutSpace(): void
    {
        $probe = new PostalCodeProbe();

        $text = 'Postcode: 1012AB area';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('1012AB', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::POSTAL_CODE, $results[0]->getProbeType());
    }
}
