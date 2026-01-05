<?php

namespace Tests\Probes\Finance\Stripe;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Stripe\StripePaymentMethodIdProbe;

/**
 * @internal
 */
class StripePaymentMethodIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expected = 'pm_ABCDEFGHIJ';
        $text = 'Value: pm_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expected = 'pm_KLMNOPQRSTUV';
        $text = 'Value: pm_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expectedFirst = 'pm_ABCDEFGHIJ';
        $expectedSecond = 'pm_KLMNOPQRSTUV';
        $text = 'First pm_ABCDEFGHIJ then pm_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expected = 'pm_ABCDEFGHIJ';
        $text = 'pm_ABCDEFGHIJ tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expected = 'pm_ABCDEFGHIJ';
        $text = 'head pm_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expected = 'pm_ABCDEFGHIJ';
        $text = 'Check pm_ABCDEFGHIJ, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expectedFirst = 'pm_ABCDEFGHIJ';
        $expectedSecond = 'pm_ABCDEFGHIJ';
        $text = 'pm_ABCDEFGHIJ and pm_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expected = 'pm_KLMNOPQRSTUV';
        $text = 'Prefix pm_KLMNOPQRSTUV suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expectedFirst = 'pm_ABCDEFGHIJ';
        $expectedSecond = 'pm_KLMNOPQRSTUV';
        $text = 'pm_ABCDEFGHIJ, pm_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new StripePaymentMethodIdProbe();

        $expected = 'pm_ABCDEFGHIJ';
        $text = 'Value: pm_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PAYMENT_METHOD_ID, $results[0]->getProbeType());
    }
}
