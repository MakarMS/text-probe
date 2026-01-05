<?php

namespace Tests\Probes\Finance\Crypto\Transaction;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Transaction\LitecoinTxIdProbe;

/**
 * @internal
 */
class LitecoinTxIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expected = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $text = 'Value: cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expected = 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
        $text = 'Value: dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expectedFirst = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $expectedSecond = 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
        $text = 'First cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc then dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(76, $results[1]->getStart());
        $this->assertSame(140, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expected = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $text = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expected = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $text = 'head cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(69, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expected = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $text = 'Check cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expectedFirst = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $expectedSecond = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $text = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc and cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(69, $results[1]->getStart());
        $this->assertSame(133, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expected = 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
        $text = 'Prefix dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expectedFirst = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $expectedSecond = 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
        $text = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc, dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(66, $results[1]->getStart());
        $this->assertSame(130, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new LitecoinTxIdProbe();

        $expected = 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $text = 'Value: cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(71, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRYPTO_LITECOIN_TX_ID, $results[0]->getProbeType());
    }
}
