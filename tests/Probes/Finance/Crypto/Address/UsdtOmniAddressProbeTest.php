<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\UsdtOmniAddressProbe;

class UsdtOmniAddressProbeTest extends TestCase
{
    public function testFindsValidOmniAddress(): void
    {
        $probe = new UsdtOmniAddressProbe();

        $text = 'Send USDT to address: 1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', $results[0]->getResult());
        $this->assertEquals(22, $results[0]->getStart());
        $this->assertEquals(56, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_OMNI_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleOmniAddresses(): void
    {
        $probe = new UsdtOmniAddressProbe();

        $text = 'Multiple addresses: 1BoatSLRHtKNngkdXEeobR76b53LETtpyT and 3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('1BoatSLRHtKNngkdXEeobR76b53LETtpyT', $results[0]->getResult());
        $this->assertEquals(20, $results[0]->getStart());
        $this->assertEquals(54, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_OMNI_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy', $results[1]->getResult());
        $this->assertEquals(59, $results[1]->getStart());
        $this->assertEquals(93, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_OMNI_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidAddresses(): void
    {
        $probe = new UsdtOmniAddressProbe();

        $text = 'Invalid addresses: 1ABC123, 2J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new UsdtOmniAddressProbe();

        $text = 'Send to 1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa, quickly!';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(42, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_OMNI_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresCompletelyInvalidString(): void
    {
        $probe = new UsdtOmniAddressProbe();

        $text = 'Random string: abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsAddressStartingWith3(): void
    {
        $probe = new UsdtOmniAddressProbe();

        $text = 'Address with prefix 3: 3FZbgi29cpjq2GjdwV8eyHuJJnkLtktZc5';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3FZbgi29cpjq2GjdwV8eyHuJJnkLtktZc5', $results[0]->getResult());
        $this->assertEquals(23, $results[0]->getStart());
        $this->assertEquals(57, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_OMNI_ADDRESS, $results[0]->getProbeType());
    }
}
