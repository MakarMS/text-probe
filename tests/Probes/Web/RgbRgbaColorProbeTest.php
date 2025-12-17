<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\RgbRgbaColorProbe;

/**
 * @internal
 */
class RgbRgbaColorProbeTest extends TestCase
{
    public function testExtractsRgbFunctions(): void
    {
        $probe = new RgbRgbaColorProbe();

        $text = 'Primary colors: rgb(255,0,0) and rgb(0, 128, 255).';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('rgb(255,0,0)', $results[0]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[0]->getProbeType());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());

        $this->assertEquals('rgb(0, 128, 255)', $results[1]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[1]->getProbeType());
        $this->assertEquals(33, $results[1]->getStart());
        $this->assertEquals(49, $results[1]->getEnd());
    }

    public function testExtractsRgbaWithAlpha(): void
    {
        $probe = new RgbRgbaColorProbe();

        $text = 'Shades: rgba(34,12,64,0.75) and rgba(10, 20, 30, 1).';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('rgba(34,12,64,0.75)', $results[0]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[0]->getProbeType());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());

        $this->assertEquals('rgba(10, 20, 30, 1)', $results[1]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[1]->getProbeType());
        $this->assertEquals(32, $results[1]->getStart());
        $this->assertEquals(51, $results[1]->getEnd());
    }

    public function testExtractsPlainRgbTriplets(): void
    {
        $probe = new RgbRgbaColorProbe();

        $text = 'CSV: 12,34,56 and also 0, 0, 0 plus 255,255,255!';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('12,34,56', $results[0]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[0]->getProbeType());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());

        $this->assertEquals('0, 0, 0', $results[1]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[1]->getProbeType());
        $this->assertEquals(23, $results[1]->getStart());
        $this->assertEquals(30, $results[1]->getEnd());

        $this->assertEquals('255,255,255', $results[2]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[2]->getProbeType());
        $this->assertEquals(36, $results[2]->getStart());
        $this->assertEquals(47, $results[2]->getEnd());
    }

    public function testSkipsOutOfRangeChannels(): void
    {
        $probe = new RgbRgbaColorProbe();

        $text = 'Bad values: rgb(300,0,0), 999,0,0 and rgba(0,0,0,0.2).';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('rgba(0,0,0,0.2)', $results[0]->getResult());
    }

    public function testSkipsInvalidAlpha(): void
    {
        $probe = new RgbRgbaColorProbe();

        $text = 'Transparency rgba(12,34,56,1.5) and rgb(10,20,30).';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('rgb(10,20,30)', $results[0]->getResult());
        $this->assertEquals(ProbeType::RGB_RGBA_COLOR, $results[0]->getProbeType());
    }
}
