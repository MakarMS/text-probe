<?php

namespace Tests\Probes\Finance\Crypto;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\CryptoXpubProbe;

/**
 * @internal
 */
class CryptoXpubProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CryptoXpubProbe();

        $expected = 'xpub661MyMwAqRbcFJx2wEJQG6fM7xA2qMafmD2Q9x8ZBv7q';
        $text = 'Value: xpub661MyMwAqRbcFJx2wEJQG6fM7xA2qMafmD2Q9x8ZBv7q';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_XPUB, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CryptoXpubProbe();

        $expected = 'xpub661MyMwAqRbcFJx2wEJQG6fM7xA2qMafmD2Q9x8ZBv7q';
        $text = 'First xpub661MyMwAqRbcFJx2wEJQG6fM7xA2qMafmD2Q9x8ZBv7q then xpub661MyMwAqRbcFJx2wEJQG6fM7xA2qMafmD2Q9x8ZBv7q';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_XPUB, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(60, $results[1]->getStart());
        $this->assertSame(108, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_XPUB, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new CryptoXpubProbe();

        $text = 'Value: xpub-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CryptoXpubProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CryptoXpubProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
