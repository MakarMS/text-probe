<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\RippleAddressProbe;

/**
 * @internal
 */
class RippleAddressProbeTest extends TestCase
{
    public function testFindsValidAddress(): void
    {
        $probe = new RippleAddressProbe();

        $text = 'My XRP address: r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_RIPPLE_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresUppercaseR(): void
    {
        $probe = new RippleAddressProbe();

        $text = 'Invalid: R9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new RippleAddressProbe();

        $text = 'My XRP address: r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59,';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_RIPPLE_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresTooShortAddress(): void
    {
        $probe = new RippleAddressProbe();

        $text = 'Too short: r12345';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresTooLongAddress(): void
    {
        $probe = new RippleAddressProbe();

        $text = 'Too long: r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59234567890';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleAddresses(): void
    {
        $probe = new RippleAddressProbe();

        $text = 'Send to r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59 or rLUEXYuLiQptky37CqLcm9USQpPiz5rkpD';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(42, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_RIPPLE_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('rLUEXYuLiQptky37CqLcm9USQpPiz5rkpD', $results[1]->getResult());
        $this->assertEquals(46, $results[1]->getStart());
        $this->assertEquals(80, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_RIPPLE_ADDRESS, $results[1]->getProbeType());
    }

    public function testDoesNotMatchWhenNoAddressPresent(): void
    {
        $probe = new RippleAddressProbe();

        $text = 'No crypto address here.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
