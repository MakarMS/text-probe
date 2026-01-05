<?php

namespace Tests\Probes\Finance\Reference;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Reference\PaymentReferenceProbe;

/**
 * @internal
 */
class PaymentReferenceProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PaymentReferenceProbe();

        $expected = 'RF47ABC123';
        $text = 'Value: RF47ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PaymentReferenceProbe();

        $expected = '123456';
        $text = 'Value: 123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PaymentReferenceProbe();

        $expectedFirst = 'RF47ABC123';
        $expectedSecond = 'RF18123456789';
        $text = 'First RF47ABC123 then RF18123456789';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(35, $results[1]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PaymentReferenceProbe();

        $expected = 'RF47ABC123';
        $text = 'RF47ABC123 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PaymentReferenceProbe();

        $expected = 'RF47ABC123';
        $text = 'head RF47ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PaymentReferenceProbe();

        $expected = 'RF47ABC123';
        $text = 'Check RF47ABC123, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PaymentReferenceProbe();

        $expectedFirst = 'RF47ABC123';
        $expectedSecond = 'RF47ABC123';
        $text = 'RF47ABC123 and RF47ABC123';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PaymentReferenceProbe();

        $expected = 'INV-123/45';
        $text = 'Prefix INV-123/45 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PaymentReferenceProbe();

        $expectedFirst = '123456';
        $expectedSecond = '987654321';
        $text = '123456, 987654321';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(6, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(8, $results[1]->getStart());
        $this->assertSame(17, $results[1]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PaymentReferenceProbe();

        $expected = 'RF47ABC123';
        $text = 'Value: RF47ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::PAYMENT_REFERENCE, $results[0]->getProbeType());
    }
}
