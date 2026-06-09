<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HttpStatusCodeProbe;

/**
 * @internal
 */
class HttpStatusCodeProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('statusSamples')]
    public function testFindsStatusCodes(string $text, string $expected, int $expectedStart, int $expectedEnd): void
    {
        $probe = new HttpStatusCodeProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame($expectedStart, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_STATUS_CODE, $results[0]->getProbeType());
    }

    public static function statusSamples(): array
    {
        return [
            ['HTTP/1.1 200', '200', 9, 12],
            ['HTTP/1.0 404', '404', 9, 12],
            ['HTTP/2 204', '204', 7, 10],
            ['HTTP/1.1 500', '500', 9, 12],
            ['HTTP/1.1 301', '301', 9, 12],
            ['HTTP/1.1 100', '100', 9, 12],
            ['HTTP/1.1 599', '599', 9, 12],
            ['418', '418', 0, 3],
            ['302', '302', 0, 3],
            ['503', '503', 0, 3],
        ];
    }
}
