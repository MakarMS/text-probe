<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\UsdcSolanaAddressProbe;

/**
 * @internal
 */
class UsdcSolanaAddressProbeTest extends TestCase
{
    public function testFindsValidSolanaAddress(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'My Solana address: 4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN', $results[0]->getResult());
        $this->assertEquals(19, $results[0]->getStart());
        $this->assertEquals(52, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleSolanaAddresses(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Solana addresses: 4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN and 5eykt4UsFv8P8NJdTREpY1vzqKqZKvdp';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN', $results[0]->getResult());
        $this->assertEquals(18, $results[0]->getStart());
        $this->assertEquals(51, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('5eykt4UsFv8P8NJdTREpY1vzqKqZKvdp', $results[1]->getResult());
        $this->assertEquals(56, $results[1]->getStart());
        $this->assertEquals(88, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidShortAddress(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Too short: 1234567890';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresInvalidLongAddress(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Too long: 1234567890123456789012345678901234567890123456789012345';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Send to Solana: 4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN,';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(49, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresCompletelyInvalidString(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Random string: abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsAddressAtStart(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = '4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN is token';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(33, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsAddressAtEnd(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Send to 5eykt4UsFv8P8NJdTREpY1vzqKqZKvdp';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('5eykt4UsFv8P8NJdTREpY1vzqKqZKvdp', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(40, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsDuplicateAddresses(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Repeat 4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN and 4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertEquals('4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(40, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN', $results[1]->getResult());
        $this->assertEquals(45, $results[1]->getStart());
        $this->assertEquals(78, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[1]->getProbeType());
    }

    public function testFindsAddressWithPeriod(): void
    {
        $probe = new UsdcSolanaAddressProbe();

        $text = 'Address: 4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('4Nd1mZy6Xf8hR7vU3t9aBcD5fG2hJkLmN', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(42, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_SOLANA_ADDRESS, $results[0]->getProbeType());
    }
}
