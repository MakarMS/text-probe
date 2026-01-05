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
    public function testFindsMatches(string $value): void
    {
        $probe = new JsonNumberValueProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_NUMBER_VALUE, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['0'],
            ['1'],
            ['-1'],
            ['42'],
            ['3.14'],
            ['-0.5'],
            ['10e2'],
            ['1E-3'],
            ['123456'],
            ['-99999'],
        ];
    }
}
