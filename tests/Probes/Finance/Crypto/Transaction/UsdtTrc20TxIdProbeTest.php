<?php

namespace Tests\Probes\Finance\Crypto\Transaction;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Transaction\UsdtTrc20TxIdProbe;

/**
 * @internal
 */
class UsdtTrc20TxIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expected = '1111111111111111111111111111111111111111111111111111111111111111';
        $text = 'Value: 1111111111111111111111111111111111111111111111111111111111111111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expected = '2222222222222222222222222222222222222222222222222222222222222222';
        $text = 'Value: 2222222222222222222222222222222222222222222222222222222222222222';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expectedFirst = '1111111111111111111111111111111111111111111111111111111111111111';
        $expectedSecond = '2222222222222222222222222222222222222222222222222222222222222222';
        $text = 'First 1111111111111111111111111111111111111111111111111111111111111111 then 2222222222222222222222222222222222222222222222222222222222222222';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(76, $results[1]->getStart());
        $this->assertSame(140, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expected = '1111111111111111111111111111111111111111111111111111111111111111';
        $text = '1111111111111111111111111111111111111111111111111111111111111111 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expected = '1111111111111111111111111111111111111111111111111111111111111111';
        $text = 'head 1111111111111111111111111111111111111111111111111111111111111111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(69, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expected = '1111111111111111111111111111111111111111111111111111111111111111';
        $text = 'Check 1111111111111111111111111111111111111111111111111111111111111111, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expectedFirst = '1111111111111111111111111111111111111111111111111111111111111111';
        $expectedSecond = '1111111111111111111111111111111111111111111111111111111111111111';
        $text = '1111111111111111111111111111111111111111111111111111111111111111 and 1111111111111111111111111111111111111111111111111111111111111111';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(69, $results[1]->getStart());
        $this->assertSame(133, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expected = '2222222222222222222222222222222222222222222222222222222222222222';
        $text = 'Prefix 2222222222222222222222222222222222222222222222222222222222222222 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expectedFirst = '1111111111111111111111111111111111111111111111111111111111111111';
        $expectedSecond = '2222222222222222222222222222222222222222222222222222222222222222';
        $text = '1111111111111111111111111111111111111111111111111111111111111111, 2222222222222222222222222222222222222222222222222222222222222222';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(66, $results[1]->getStart());
        $this->assertSame(130, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new UsdtTrc20TxIdProbe();

        $expected = '1111111111111111111111111111111111111111111111111111111111111111';
        $text = 'Value: 1111111111111111111111111111111111111111111111111111111111111111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_TRC20_TX_ID, $results[0]->getProbeType());
    }
}
