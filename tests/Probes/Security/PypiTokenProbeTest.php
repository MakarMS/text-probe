<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\PypiTokenProbe;

/**
 * @internal
 */
class PypiTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PypiTokenProbe();

        $expected = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PypiTokenProbe();

        $expected = 'pypi-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $text = 'pypi-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PypiTokenProbe();

        $first = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $second = 'pypi-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $text = 'pypi-abcdefghijklmnopqrstuvwxyz_123456' . "\n" . 'pypi-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(39, $results[1]->getStart());
        $this->assertSame(77, $results[1]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PypiTokenProbe();

        $expected = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PypiTokenProbe();

        $expected = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PypiTokenProbe();

        $expected = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new PypiTokenProbe();

        $text = 'pypi-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new PypiTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new PypiTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new PypiTokenProbe();

        $expected = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'pypi-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::PYPI_TOKEN, $results[0]->getProbeType());
    }
}
