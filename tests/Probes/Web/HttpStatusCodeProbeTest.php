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
    public function testFindsStatusCodes(string $text, string $expected): void
    {
        $probe = new HttpStatusCodeProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strpos($text, $expected), $results[0]->getStart());
        $this->assertSame(strpos($text, $expected) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_STATUS_CODE, $results[0]->getProbeType());
    }

    public static function statusSamples(): array
    {
        return [
            ['HTTP/1.1 200', '200'],
            ['HTTP/1.0 404', '404'],
            ['HTTP/2 204', '204'],
            ['HTTP/1.1 500', '500'],
            ['HTTP/1.1 301', '301'],
            ['HTTP/1.1 100', '100'],
            ['HTTP/1.1 599', '599'],
            ['418', '418'],
            ['302', '302'],
            ['503', '503'],
        ];
    }
}
