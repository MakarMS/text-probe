<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\JsonValueProbe;

/**
 * @internal
 */
class JsonValueProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('valueSamples')]
    public function testFindsValues(string $value, int $expectedEnd): void
    {
        $probe = new JsonValueProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_VALUE, $results[0]->getProbeType());
    }

    public static function valueSamples(): array
    {
        return [
            ['"value"', 7],
            ['"with space"', 12],
            ['0', 1],
            ['42', 2],
            ['-1', 2],
            ['3.14', 4],
            ['true', 4],
            ['false', 5],
            ['null', 4],
            ['1e3', 3],
        ];
    }
}
