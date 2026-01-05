<?php

namespace Tests\Probes\Finance\Stripe;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Stripe\StripeChargeIdProbe;

/**
 * @internal
 */
class StripeChargeIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new StripeChargeIdProbe();

        $expected = 'ch_ABCDEFGHIJ';
        $text = 'Value: ch_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new StripeChargeIdProbe();

        $expected = 'ch_KLMNOPQRSTUV';
        $text = 'Value: ch_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new StripeChargeIdProbe();

        $expectedFirst = 'ch_ABCDEFGHIJ';
        $expectedSecond = 'ch_KLMNOPQRSTUV';
        $text = 'First ch_ABCDEFGHIJ then ch_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new StripeChargeIdProbe();

        $expected = 'ch_ABCDEFGHIJ';
        $text = 'ch_ABCDEFGHIJ tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new StripeChargeIdProbe();

        $expected = 'ch_ABCDEFGHIJ';
        $text = 'head ch_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new StripeChargeIdProbe();

        $expected = 'ch_ABCDEFGHIJ';
        $text = 'Check ch_ABCDEFGHIJ, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new StripeChargeIdProbe();

        $expectedFirst = 'ch_ABCDEFGHIJ';
        $expectedSecond = 'ch_ABCDEFGHIJ';
        $text = 'ch_ABCDEFGHIJ and ch_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new StripeChargeIdProbe();

        $expected = 'ch_KLMNOPQRSTUV';
        $text = 'Prefix ch_KLMNOPQRSTUV suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new StripeChargeIdProbe();

        $expectedFirst = 'ch_ABCDEFGHIJ';
        $expectedSecond = 'ch_KLMNOPQRSTUV';
        $text = 'ch_ABCDEFGHIJ, ch_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new StripeChargeIdProbe();

        $expected = 'ch_ABCDEFGHIJ';
        $text = 'Value: ch_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CHARGE_ID, $results[0]->getProbeType());
    }
}
