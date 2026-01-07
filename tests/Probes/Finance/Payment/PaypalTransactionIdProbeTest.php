<?php

namespace Tests\Probes\Finance\Payment;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Payment\PaypalTransactionIdProbe;

/**
 * @internal
 */
class PaypalTransactionIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expected = 'ABCD1234EFGH56789';
        $text = 'Value: ABCD1234EFGH56789';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expected = 'ZXCVBNM1234567890';
        $text = 'Value: ZXCVBNM1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expectedFirst = 'ABCD1234EFGH56789';
        $expectedSecond = 'ZXCVBNM1234567890';
        $text = 'First ABCD1234EFGH56789 then ZXCVBNM1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(46, $results[1]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expected = 'ABCD1234EFGH56789';
        $text = 'ABCD1234EFGH56789 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expected = 'ABCD1234EFGH56789';
        $text = 'head ABCD1234EFGH56789';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expected = 'ABCD1234EFGH56789';
        $text = 'Check ABCD1234EFGH56789, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expectedFirst = 'ABCD1234EFGH56789';
        $expectedSecond = 'ABCD1234EFGH56789';
        $text = 'ABCD1234EFGH56789 and ABCD1234EFGH56789';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(39, $results[1]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expected = 'ZXCVBNM1234567890';
        $text = 'Prefix ZXCVBNM1234567890 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expectedFirst = 'ABCD1234EFGH56789';
        $expectedSecond = 'ZXCVBNM1234567890';
        $text = 'ABCD1234EFGH56789, ZXCVBNM1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(19, $results[1]->getStart());
        $this->assertSame(36, $results[1]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PaypalTransactionIdProbe();

        $expected = 'ABCD1234EFGH56789';
        $text = 'Value: ABCD1234EFGH56789';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYPAL_TRANSACTION_ID, $results[0]->getProbeType());
    }
}
