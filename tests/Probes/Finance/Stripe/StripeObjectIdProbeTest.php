<?php

namespace Tests\Probes\Finance\Stripe;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Stripe\StripeObjectIdProbe;

/**
 * @internal
 */
class StripeObjectIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new StripeObjectIdProbe();

        $expected = 'pi_ABC123';
        $text = 'Value: pi_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new StripeObjectIdProbe();

        $expected = 'evt_DEF4567';
        $text = 'Value: evt_DEF4567';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new StripeObjectIdProbe();

        $expectedFirst = 'pi_ABC123';
        $expectedSecond = 'evt_DEF4567';
        $text = 'First pi_ABC123 then evt_DEF4567';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new StripeObjectIdProbe();

        $expected = 'pi_ABC123';
        $text = 'pi_ABC123 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new StripeObjectIdProbe();

        $expected = 'pi_ABC123';
        $text = 'head pi_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new StripeObjectIdProbe();

        $expected = 'pi_ABC123';
        $text = 'Check pi_ABC123, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new StripeObjectIdProbe();

        $expectedFirst = 'pi_ABC123';
        $expectedSecond = 'pi_ABC123';
        $text = 'pi_ABC123 and pi_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(14, $results[1]->getStart());
        $this->assertSame(23, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new StripeObjectIdProbe();

        $expected = 'evt_DEF4567';
        $text = 'Prefix evt_DEF4567 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new StripeObjectIdProbe();

        $expectedFirst = 'pi_ABC123';
        $expectedSecond = 'evt_DEF4567';
        $text = 'pi_ABC123, evt_DEF4567';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(11, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new StripeObjectIdProbe();

        $expected = 'pi_ABC123';
        $text = 'Value: pi_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_OBJECT_ID, $results[0]->getProbeType());
    }
}
