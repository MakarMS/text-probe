<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\StripePublishableKeyProbe;

/**
 * @internal
 */
class StripePublishableKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expected = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'Value: pk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expected = 'pk_live_1234567890ABCDEFGHIJ';
        $text = 'Value: pk_live_1234567890ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(35, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expectedFirst = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $expectedSecond = 'pk_live_1234567890ABCDEFGHIJ';
        $text = 'First pk_test_abcdefghijklmnopqrstuvwxyz then pk_live_1234567890ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(46, $results[1]->getStart());
        $this->assertSame(74, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expected = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'pk_test_abcdefghijklmnopqrstuvwxyz tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expected = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'head pk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expected = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'Check pk_test_abcdefghijklmnopqrstuvwxyz, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expectedFirst = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $expectedSecond = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'pk_test_abcdefghijklmnopqrstuvwxyz and pk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(39, $results[1]->getStart());
        $this->assertSame(73, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expected = 'pk_live_1234567890ABCDEFGHIJ';
        $text = 'Prefix pk_live_1234567890ABCDEFGHIJ suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(35, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expectedFirst = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $expectedSecond = 'pk_live_1234567890ABCDEFGHIJ';
        $text = 'pk_test_abcdefghijklmnopqrstuvwxyz, pk_live_1234567890ABCDEFGHIJ';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(36, $results[1]->getStart());
        $this->assertSame(64, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new StripePublishableKeyProbe();

        $expected = 'pk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'Value: pk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_PUBLISHABLE_KEY, $results[0]->getProbeType());
    }
}
