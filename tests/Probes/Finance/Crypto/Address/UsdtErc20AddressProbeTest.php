<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\UsdtErc20AddressProbe;

/**
 * @internal
 */
class UsdtErc20AddressProbeTest extends TestCase
{
    public function testFindsValidAddress(): void
    {
        $probe = new UsdtErc20AddressProbe();

        $text = 'My USDT address: 0xAbC1234567890abcdef1234567890ABCDEF12345';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0xAbC1234567890abcdef1234567890ABCDEF12345', $results[0]->getResult());
        $this->assertEquals(17, $results[0]->getStart());
        $this->assertEquals(59, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_ERC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleAddresses(): void
    {
        $probe = new UsdtErc20AddressProbe();

        $text = 'Addresses: 0x1a8b3c4d5e6f7a8b9c0d1e2f3a4b5c6d7e8f9a0b and 0xbadc0ffeea8b3c4d5e6f7a8b9c0d1e2f3a4b5c6d';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('0x1a8b3c4d5e6f7a8b9c0d1e2f3a4b5c6d7e8f9a0b', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(53, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_ERC20_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('0xbadc0ffeea8b3c4d5e6f7a8b9c0d1e2f3a4b5c6d', $results[1]->getResult());
        $this->assertEquals(58, $results[1]->getStart());
        $this->assertEquals(100, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_ERC20_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidString(): void
    {
        $probe = new UsdtErc20AddressProbe();

        $text = 'Invalid: 0x12345 or 0xGHIJK1234567890abcdef1234567890ABCDE';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testHandlesLowercaseAddress(): void
    {
        $probe = new UsdtErc20AddressProbe();

        $text = 'Lowercase: 0xabcdef1234567890abcdef1234567890abcdef12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0xabcdef1234567890abcdef1234567890abcdef12', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(53, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_ERC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new UsdtErc20AddressProbe();

        $text = 'Send to: 0x9876543210fedcba9876543210fedcba98765432.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0x9876543210fedcba9876543210fedcba98765432', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(51, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_ERC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresTooShortOrTooLongAddresses(): void
    {
        $probe = new UsdtErc20AddressProbe();

        $text = 'Short: 0x12345, Long: 0x1234567890abcdef1234567890abcdef1234567890123456';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsAddressAmidTextWithSeparators(): void
    {
        $probe = new UsdtErc20AddressProbe();

        $text = 'Transfer to 0xf0e1d2c3b4a59876543210fedcba9876543210fe, then check balance.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0xf0e1d2c3b4a59876543210fedcba9876543210fe', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(54, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDT_ERC20_ADDRESS, $results[0]->getProbeType());
    }
}
