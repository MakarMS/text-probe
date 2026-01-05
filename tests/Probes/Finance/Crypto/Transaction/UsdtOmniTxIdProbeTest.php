<?php

namespace Tests\Probes\Finance\Crypto\Transaction;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Transaction\UsdtOmniTxIdProbe;

/**
 * @internal
 */
class UsdtOmniTxIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expected = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'Value: ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expected = 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'Value: eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expectedFirst = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $expectedSecond = 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'First ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff then eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(76, $results[1]->getStart());
        $this->assertSame(140, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expected = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expected = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'head ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(69, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expected = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'Check ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expectedFirst = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $expectedSecond = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff and ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(69, $results[1]->getStart());
        $this->assertSame(133, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expected = 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'Prefix eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expectedFirst = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $expectedSecond = 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $text = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff, eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(66, $results[1]->getStart());
        $this->assertSame(130, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new UsdtOmniTxIdProbe();

        $expected = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $text = 'Value: ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_USDT_OMNI_TX_ID, $results[0]->getProbeType());
    }
}
