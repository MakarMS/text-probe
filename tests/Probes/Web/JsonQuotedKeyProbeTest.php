<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\JsonQuotedKeyProbe;

/**
 * @internal
 */
class JsonQuotedKeyProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('quotedKeys')]
    public function testFindsQuotedKeys(string $text, string $expected, int $expectedEnd): void
    {
        $probe = new JsonQuotedKeyProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_QUOTED_KEY, $results[0]->getProbeType());
    }

    public static function quotedKeys(): array
    {
        return [
            ['"name":', '"name"', 6],
            ['"age":', '"age"', 5],
            ['"email":', '"email"', 7],
            ['"user_id":', '"user_id"', 9],
            ['"first-name":', '"first-name"', 12],
            ['"lastName":', '"lastName"', 10],
            ['"address.line1":', '"address.line1"', 15],
            ['"phone_number":', '"phone_number"', 14],
            ['"isActive":', '"isActive"', 10],
            ['"country":', '"country"', 9],
        ];
    }
}
