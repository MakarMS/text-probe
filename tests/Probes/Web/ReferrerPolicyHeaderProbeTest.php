<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\ReferrerPolicyHeaderProbe;

/**
 * @internal
 */
class ReferrerPolicyHeaderProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $expected = 'Referrer-Policy: no-referrer';
        $text = 'Referrer-Policy: no-referrer';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(28, $results[0]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $expected = 'Referrer-Policy: strict-origin-when-cross-origin';
        $text = 'Referrer-Policy: strict-origin-when-cross-origin';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(48, $results[0]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $first = 'Referrer-Policy: no-referrer';
        $second = 'Referrer-Policy: strict-origin-when-cross-origin';
        $text = 'Referrer-Policy: no-referrer' . "\n" . 'Referrer-Policy: strict-origin-when-cross-origin';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(28, $results[0]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(77, $results[1]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $expected = 'Referrer-Policy: no-referrer';
        $text = 'Referrer-Policy: no-referrer';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(28, $results[0]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $expected = 'Referrer-Policy: no-referrer';
        $text = 'Referrer-Policy: no-referrer';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(28, $results[0]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $expected = 'Referrer-Policy: no-referrer';
        $text = 'Referrer-Policy: no-referrer';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(28, $results[0]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $text = 'Referrer-Policy: invalid';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new ReferrerPolicyHeaderProbe();

        $expected = 'Referrer-Policy: no-referrer';
        $text = 'Referrer-Policy: no-referrer';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(28, $results[0]->getEnd());
        $this->assertSame(ProbeType::REFERRER_POLICY_HEADER, $results[0]->getProbeType());
    }
}
