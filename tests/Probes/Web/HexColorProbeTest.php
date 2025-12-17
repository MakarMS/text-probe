<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HexColorProbe;

/**
 * @internal
 */
class HexColorProbeTest extends TestCase
{
    public function testShortHexColor(): void
    {
        $probe = new HexColorProbe();

        $text = 'Short hex: #abc used here.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('#abc', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HEX_COLOR, $results[0]->getProbeType());
    }

    public function testFullHexColorUppercase(): void
    {
        $probe = new HexColorProbe();

        $text = '#1A2B3C is the primary color.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('#1A2B3C', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(7, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HEX_COLOR, $results[0]->getProbeType());
    }

    public function testMultipleHexColors(): void
    {
        $probe = new HexColorProbe();

        $text = 'Colors: #fff,#123456 and background.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('#fff', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HEX_COLOR, $results[0]->getProbeType());

        $this->assertEquals('#123456', $results[1]->getResult());
        $this->assertEquals(13, $results[1]->getStart());
        $this->assertEquals(20, $results[1]->getEnd());
        $this->assertEquals(ProbeType::HEX_COLOR, $results[1]->getProbeType());
    }

    public function testDoesNotMatchInvalidLengths(): void
    {
        $probe = new HexColorProbe();

        $text = 'Invalid colors like #abcd, #1234, or #1234567 should be ignored.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testBoundariesAroundHexColor(): void
    {
        $probe = new HexColorProbe();

        $text = 'Edge cases:abc#fff123 should not match, but #abc123 should match only once.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('#abc123', $results[0]->getResult());
        $this->assertEquals(44, $results[0]->getStart());
        $this->assertEquals(51, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HEX_COLOR, $results[0]->getProbeType());
    }
}
