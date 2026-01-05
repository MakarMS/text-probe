<?php

namespace Tests\Probes\Finance\Stripe;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Stripe\StripeEventIdProbe;

/**
 * @internal
 */
class StripeEventIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new StripeEventIdProbe();

        $expected = 'evt_ABCDEFGHIJ';
        $text = 'Value: evt_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new StripeEventIdProbe();

        $expected = 'evt_KLMNOPQRSTUV';
        $text = 'Value: evt_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new StripeEventIdProbe();

        $expectedFirst = 'evt_ABCDEFGHIJ';
        $expectedSecond = 'evt_KLMNOPQRSTUV';
        $text = 'First evt_ABCDEFGHIJ then evt_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(42, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new StripeEventIdProbe();

        $expected = 'evt_ABCDEFGHIJ';
        $text = 'evt_ABCDEFGHIJ tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new StripeEventIdProbe();

        $expected = 'evt_ABCDEFGHIJ';
        $text = 'head evt_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new StripeEventIdProbe();

        $expected = 'evt_ABCDEFGHIJ';
        $text = 'Check evt_ABCDEFGHIJ, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new StripeEventIdProbe();

        $expectedFirst = 'evt_ABCDEFGHIJ';
        $expectedSecond = 'evt_ABCDEFGHIJ';
        $text = 'evt_ABCDEFGHIJ and evt_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(19, $results[1]->getStart());
        $this->assertSame(33, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new StripeEventIdProbe();

        $expected = 'evt_KLMNOPQRSTUV';
        $text = 'Prefix evt_KLMNOPQRSTUV suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new StripeEventIdProbe();

        $expectedFirst = 'evt_ABCDEFGHIJ';
        $expectedSecond = 'evt_KLMNOPQRSTUV';
        $text = 'evt_ABCDEFGHIJ, evt_KLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new StripeEventIdProbe();

        $expected = 'evt_ABCDEFGHIJ';
        $text = 'Value: evt_ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_EVENT_ID, $results[0]->getProbeType());
    }
}
