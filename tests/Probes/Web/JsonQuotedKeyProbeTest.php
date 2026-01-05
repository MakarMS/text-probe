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
    public function testFindsQuotedKeys(string $text, string $expected): void
    {
        $probe = new JsonQuotedKeyProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_QUOTED_KEY, $results[0]->getProbeType());
    }

    public static function quotedKeys(): array
    {
        return [
            ['"name":', '"name"'],
            ['"age":', '"age"'],
            ['"email":', '"email"'],
            ['"user_id":', '"user_id"'],
            ['"first-name":', '"first-name"'],
            ['"lastName":', '"lastName"'],
            ['"address.line1":', '"address.line1"'],
            ['"phone_number":', '"phone_number"'],
            ['"isActive":', '"isActive"'],
            ['"country":', '"country"'],
        ];
    }
}
