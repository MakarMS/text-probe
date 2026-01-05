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
    public function testFindsKeys(string $text, string $expected): void
    {
        $probe = new JsonKeyProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::JSON_KEY, $results[0]->getProbeType());
    }

    public static function keys(): array
    {
        return [
            ['name:', 'name'],
            ['age:', 'age'],
            ['email:', 'email'],
            ['user_id:', 'user_id'],
            ['firstName:', 'firstName'],
            ['last_name:', 'last_name'],
            ['address1:', 'address1'],
            ['phoneNumber:', 'phoneNumber'],
            ['isActive:', 'isActive'],
            ['country:', 'country'],
        ];
    }
}
