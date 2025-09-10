<?php

namespace Tests\Probes;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\GeoCoordinatesProbe;

class GeoCoordinatesProbeTest extends TestCase
{
    public function testFindsDecimalDegrees(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "Coordinates: 55.7558, 37.6173";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('55.7558, 37.6173', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }

    public function testFindsDecimalDegreesWithSemicolon(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "New York: 40.7128;-74.0060";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('40.7128;-74.0060', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }

    public function testFindsDMFormat(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "Example DM: 55°45.500′N 37°37.000′E";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals("55°45.500′N 37°37.000′E", $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(35, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }

    public function testFindsDMSFormat(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "Example DMS: 55°45′21″ N, 37°36′56″ E";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals("55°45′21″ N, 37°36′56″ E", $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(37, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }

    public function testFindsNegativeDecimalDegrees(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "Location: -33.865143, 151.209900";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('-33.865143, 151.209900', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(32, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }

    public function testFindsDMFormatWithSpaces(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "DM Example: 51°30.000′ N 0°7.000′ W";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('51°30.000′ N 0°7.000′ W', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(35, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }

    public function testFindsDMSFormatWithCommas(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "DMS Example: 34°3′8″ S, 18°25′26″ E";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('34°3′8″ S, 18°25′26″ E', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(35, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }

    public function testFindsMultipleDecimalDegrees(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "Coords: 40.7128, -74.0060 and 34.0522, -118.2437";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('40.7128, -74.0060', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());

        $this->assertEquals('34.0522, -118.2437', $results[1]->getResult());
        $this->assertEquals(30, $results[1]->getStart());
        $this->assertEquals(48, $results[1]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[1]->getProbeType());
    }

    public function testFindsDecimalDegreesWithSpaceAfterSemicolon(): void
    {
        $probe = new GeoCoordinatesProbe();

        $text = "Location: 35.6895; 139.6917";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('35.6895; 139.6917', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GEO_COORDINATES, $results[0]->getProbeType());
    }
}