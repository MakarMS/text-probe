<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\LitecoinAddressProbe;

/**
 * @internal
 */
class LitecoinAddressProbeTest extends TestCase
{
    public function testFindsP2PKHAddress(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'My LTC address: LZHVjYyLkJ5PaKbYXbW8s2mhN4Uu4f2rFq';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('LZHVjYyLkJ5PaKbYXbW8s2mhN4Uu4f2rFq', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsP2SHAddress(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'Pay to LTC address: M9Bszq7ZrZ7Bv9H7h1RfHJe1f8RpmQ7bB3';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('M9Bszq7ZrZ7Bv9H7h1RfHJe1f8RpmQ7bB3', $results[0]->getResult());
        $this->assertEquals(20, $results[0]->getStart());
        $this->assertEquals(54, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsBech32Address(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'Send to ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(51, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidAddress(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'Invalid LTC: L123';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'Pay to LTC address: ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m,';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m', $results[0]->getResult());
        $this->assertEquals(20, $results[0]->getStart());
        $this->assertEquals(63, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleAddresses(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'Addresses: LZHVjYyLkJ5PaKbYXbW8s2mhN4Uu4f2rFq and ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('LZHVjYyLkJ5PaKbYXbW8s2mhN4Uu4f2rFq', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(45, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m', $results[1]->getResult());
        $this->assertEquals(50, $results[1]->getStart());
        $this->assertEquals(93, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[1]->getProbeType());
    }

    public function testFindsAddressInLowercase(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'Send to LTC address: LzHVjYyLkJ5PaKbYXbW8s2mhN4Uu4f2rFq';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('LzHVjYyLkJ5PaKbYXbW8s2mhN4Uu4f2rFq', $results[0]->getResult());
        $this->assertEquals(21, $results[0]->getStart());
        $this->assertEquals(55, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsBech32AddressLowercase(): void
    {
        $probe = new LitecoinAddressProbe();

        $text = 'Pay to address: ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ltc1q0c5l0z7r2dpw5hjr9jhdf5x8f7f3g5zv7v0s0m', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(59, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_LITECOIN_ADDRESS, $results[0]->getProbeType());
    }
}
