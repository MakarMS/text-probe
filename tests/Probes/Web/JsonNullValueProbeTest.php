<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\JsonNullValueProbe;

/**
 * @internal
 */
class JsonNullValueProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new JsonNullValueProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_NULL_VALUE, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['null'],
            ['null'],
            ['null'],
            ['null'],
            ['null'],
            ['null'],
            ['null'],
            ['null'],
            ['null'],
            ['null'],
        ];
    }
}
