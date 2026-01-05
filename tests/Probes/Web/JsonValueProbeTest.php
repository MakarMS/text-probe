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
    public function testFindsValues(string $value): void
    {
        $probe = new JsonValueProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_VALUE, $results[0]->getProbeType());
    }

    public static function valueSamples(): array
    {
        return [
            ['"value"'],
            ['"with space"'],
            ['0'],
            ['42'],
            ['-1'],
            ['3.14'],
            ['true'],
            ['false'],
            ['null'],
            ['1e3'],
        ];
    }
}
