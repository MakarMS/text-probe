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
    public function testFindsMatches(string $value): void
    {
        $probe = new JsonStringValueProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(mb_strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_STRING_VALUE, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['"value"'],
            ['"with space"'],
            ['"123"'],
            ['"true"'],
            ['"null"'],
            ['"hello-world"'],
            ['"underscore_value"'],
            ['"emoji 🚀"'],
            ['"escaped \"quote\""'],
            ['"slashes \/"'],
        ];
    }
}
