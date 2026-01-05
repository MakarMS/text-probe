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
    public function testFindsMatches(string $value): void
    {
        $probe = new HttpStatusLineProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_STATUS_LINE, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['HTTP/1.1 200'],
            ['HTTP/1.0 404'],
            ['HTTP/2 204'],
            ['HTTP/1.1 500'],
            ['HTTP/1.1 301'],
            ['HTTP/1.1 100'],
            ['HTTP/1.1 599'],
            ['HTTP/1 418'],
            ['HTTP/3 302'],
            ['HTTP/2.0 503'],
        ];
    }
}
