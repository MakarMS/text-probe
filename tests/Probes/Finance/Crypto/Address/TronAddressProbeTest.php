<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\TronAddressProbe;

/**
 * @internal
 */
class TronAddressProbeTest extends TestCase
{
    public function testFindsValidTronAddress(): void
    {
        $probe = new TronAddressProbe();

        $text = 'My Tron address: TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3', $results[0]->getResult());
        $this->assertEquals(17, $results[0]->getStart());
        $this->assertEquals(51, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_TRON_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleValidTronAddresses(): void
    {
        $probe = new TronAddressProbe();

        $text = 'Tron addresses: TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3 and TAbC1dE2FgH3JkL4MnP5QrS6TuV7WxY8Za';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_TRON_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('TAbC1dE2FgH3JkL4MnP5QrS6TuV7WxY8Za', $results[1]->getResult());
        $this->assertEquals(55, $results[1]->getStart());
        $this->assertEquals(89, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_TRON_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidShortAddress(): void
    {
        $probe = new TronAddressProbe();

        $text = 'Too short: T1234567890';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresInvalidLongAddress(): void
    {
        $probe = new TronAddressProbe();

        $text = 'Too long: T123456789012345678901234567890123456789012345678';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsLowercaseAddress(): void
    {
        $probe = new TronAddressProbe();

        $text = 'Lowercase: tq1r4qkfZ5eXz8b3h1ml7g2pqy6jvn9wz3';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new TronAddressProbe();

        $text = 'Send to Tron: TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3,';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(48, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_TRON_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresCompletelyInvalidString(): void
    {
        $probe = new TronAddressProbe();

        $text = 'This is not an address: ABCDEFGHIJKLMNOPQRSTUVWXYZ12345';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
