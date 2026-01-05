<?php

namespace Tests\Probes\Finance\Stripe;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Stripe\StripeCustomerIdProbe;

/**
 * @internal
 */
class StripeCustomerIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expected = 'cus_ABC123';
        $text = 'Value: cus_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expected = 'cus_DEF4567';
        $text = 'Value: cus_DEF4567';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expectedFirst = 'cus_ABC123';
        $expectedSecond = 'cus_DEF4567';
        $text = 'First cus_ABC123 then cus_DEF4567';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(33, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expected = 'cus_ABC123';
        $text = 'cus_ABC123 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expected = 'cus_ABC123';
        $text = 'head cus_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expected = 'cus_ABC123';
        $text = 'Check cus_ABC123, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expectedFirst = 'cus_ABC123';
        $expectedSecond = 'cus_ABC123';
        $text = 'cus_ABC123 and cus_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expected = 'cus_DEF4567';
        $text = 'Prefix cus_DEF4567 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expectedFirst = 'cus_ABC123';
        $expectedSecond = 'cus_DEF4567';
        $text = 'cus_ABC123, cus_DEF4567';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(23, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new StripeCustomerIdProbe();

        $expected = 'cus_ABC123';
        $text = 'Value: cus_ABC123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_CUSTOMER_ID, $results[0]->getProbeType());
    }
}
