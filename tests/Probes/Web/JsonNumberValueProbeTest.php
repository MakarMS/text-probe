<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\JsonNumberValueProbe;

/**
 * @internal
 */
class JsonNumberValueProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new JsonNumberValueProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_NUMBER_VALUE, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['0', 1],
            ['1', 1],
            ['-1', 2],
            ['42', 2],
            ['3.14', 4],
            ['-0.5', 4],
            ['10e2', 4],
            ['1E-3', 4],
            ['123456', 6],
            ['-99999', 6],
        ];
    }
}
