<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\StripeWebhookSecretProbe;

/**
 * @internal
 */
class StripeWebhookSecretProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new StripeWebhookSecretProbe();

        $expected = 'whsec_1234567890abcdefABCDEF12';
        $text = 'Value: whsec_1234567890abcdefABCDEF12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_WEBHOOK_SECRET, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new StripeWebhookSecretProbe();

        $expected = 'whsec_1234567890abcdefABCDEF12';
        $text = 'First whsec_1234567890abcdefABCDEF12 then whsec_1234567890abcdefABCDEF12';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::STRIPE_WEBHOOK_SECRET, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(42, $results[1]->getStart());
        $this->assertSame(72, $results[1]->getEnd());
        $this->assertSame(ProbeType::STRIPE_WEBHOOK_SECRET, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new StripeWebhookSecretProbe();

        $text = 'Value: whsec_short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new StripeWebhookSecretProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new StripeWebhookSecretProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
