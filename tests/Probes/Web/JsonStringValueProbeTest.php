<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\JsonStringValueProbe;

/**
 * @internal
 */
class JsonStringValueProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new JsonStringValueProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_STRING_VALUE, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['"value"', 7],
            ['"with space"', 12],
            ['"123"', 5],
            ['"true"', 6],
            ['"null"', 6],
            ['"hello-world"', 13],
            ['"underscore_value"', 18],
            ['"emoji 🚀"', 9],
            ['"escaped \"quote\""', 19],
            ['"slashes \/"', 12],
        ];
    }
}
