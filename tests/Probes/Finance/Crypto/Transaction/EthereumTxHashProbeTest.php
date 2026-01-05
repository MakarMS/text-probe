<?php

namespace Tests\Probes\Finance\Crypto\Transaction;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Transaction\EthereumTxHashProbe;

/**
 * @internal
 */
class EthereumTxHashProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EthereumTxHashProbe();

        $expected = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'Value: 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new EthereumTxHashProbe();

        $expected = '0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $text = 'Value: 0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EthereumTxHashProbe();

        $expectedFirst = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $expectedSecond = '0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $text = 'First 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa then 0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(72, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(78, $results[1]->getStart());
        $this->assertSame(144, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new EthereumTxHashProbe();

        $expected = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new EthereumTxHashProbe();

        $expected = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'head 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new EthereumTxHashProbe();

        $expected = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'Check 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(72, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new EthereumTxHashProbe();

        $expectedFirst = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $expectedSecond = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa and 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(71, $results[1]->getStart());
        $this->assertSame(137, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new EthereumTxHashProbe();

        $expected = '0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $text = 'Prefix 0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new EthereumTxHashProbe();

        $expectedFirst = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $expectedSecond = '0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $text = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa, 0xbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(68, $results[1]->getStart());
        $this->assertSame(134, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new EthereumTxHashProbe();

        $expected = '0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'Value: 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_ETHEREUM_TX_HASH, $results[0]->getProbeType());
    }
}
