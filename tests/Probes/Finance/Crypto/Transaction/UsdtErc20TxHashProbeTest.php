<?php

namespace Tests\Probes\Finance\Crypto\Transaction;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Transaction\UsdtErc20TxHashProbe;

/**
 * @internal
 */
class UsdtErc20TxHashProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expected = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'Value: 0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expected = '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'Value: 0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expectedFirst = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $expectedSecond = '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'First 0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee then 0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(72, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(78, $results[1]->getStart());
        $this->assertSame(144, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expected = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expected = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'head 0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expected = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'Check 0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(72, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expectedFirst = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $expectedSecond = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee and 0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(71, $results[1]->getStart());
        $this->assertSame(137, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expected = '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'Prefix 0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expectedFirst = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $expectedSecond = '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee, 0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(68, $results[1]->getStart());
        $this->assertSame(134, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new UsdtErc20TxHashProbe();

        $expected = '0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'Value: 0xeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(73, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_ERC20_TX_HASH, $results[0]->getProbeType());
    }
}
