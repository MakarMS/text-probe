<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\JsonKeyProbe;

/**
 * @internal
 */
class JsonKeyProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('keys')]
    public function testFindsKeys(string $text, string $expected, int $expectedEnd): void
    {
        $probe = new JsonKeyProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_KEY, $results[0]->getProbeType());
    }

    public static function keys(): array
    {
        return [
            ['name:', 'name', 4],
            ['age:', 'age', 3],
            ['email:', 'email', 5],
            ['user_id:', 'user_id', 7],
            ['firstName:', 'firstName', 9],
            ['last_name:', 'last_name', 9],
            ['address1:', 'address1', 8],
            ['phoneNumber:', 'phoneNumber', 11],
            ['isActive:', 'isActive', 8],
            ['country:', 'country', 7],
        ];
    }
}
