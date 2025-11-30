<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\UsdtTrc20AddressProbe;

/**
 * @internal
 */
class UsdtTrc20AddressProbeTest extends TestCase
{
    public function testFindsValidTrc20Address(): void
    {
        $probe = new UsdtTrc20AddressProbe();

        $text = 'Send USDT to address: TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3', $results[0]->getResult());
        $this->assertEquals(22, $results[0]->getStart());
        $this->assertEquals(56, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_TRC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleTrc20Addresses(): void
    {
        $probe = new UsdtTrc20AddressProbe();

        $text = 'Two TRC20 addresses: TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3 and TFr5s2gXCKsS4B5p2k6G2pQY6JvN9sJkLp';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3', $results[0]->getResult());
        $this->assertEquals(21, $results[0]->getStart());
        $this->assertEquals(55, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_TRC20_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('TFr5s2gXCKsS4B5p2k6G2pQY6JvN9sJkLp', $results[1]->getResult());
        $this->assertEquals(60, $results[1]->getStart());
        $this->assertEquals(94, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_TRC20_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidAddresses(): void
    {
        $probe = new UsdtTrc20AddressProbe();

        $text = 'Invalid TRC20 addresses: T1234567890ABCDEF1234567890ABCDEF1, TXYZ1234567890ABCDEF1234567890ABCD';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new UsdtTrc20AddressProbe();

        $text = 'Send to TRC20: TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3, quickly!';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('TQ1r4qkFz5eXz8B3H1mL7G2PqY6JvN9WZ3', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(49, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_TRC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresCompletelyRandomString(): void
    {
        $probe = new UsdtTrc20AddressProbe();

        $text = 'Random string: abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsAddressWithinUrl(): void
    {
        $probe = new UsdtTrc20AddressProbe();

        $text = 'Check the address on TronScan: https://tronscan.org/#/address/TFr5s2gXCKsS4B5p2k6G2pQY6JvN9sJkLp';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('TFr5s2gXCKsS4B5p2k6G2pQY6JvN9sJkLp', $results[0]->getResult());
        $this->assertEquals(62, $results[0]->getStart());
        $this->assertEquals(96, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_TRC20_ADDRESS, $results[0]->getProbeType());
    }
}
