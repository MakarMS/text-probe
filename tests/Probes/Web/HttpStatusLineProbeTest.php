<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HttpStatusLineProbe;

/**
 * @internal
 */
class HttpStatusLineProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new HttpStatusLineProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_STATUS_LINE, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['HTTP/1.1 200', 12],
            ['HTTP/1.0 404', 12],
            ['HTTP/2 204', 10],
            ['HTTP/1.1 500', 12],
            ['HTTP/1.1 301', 12],
            ['HTTP/1.1 100', 12],
            ['HTTP/1.1 599', 12],
            ['HTTP/1 418', 10],
            ['HTTP/3 302', 10],
            ['HTTP/2.0 503', 12],
        ];
    }
}
