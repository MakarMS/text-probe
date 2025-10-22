<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\UsdcErc20AddressProbe;

class UsdcErc20AddressProbeTest extends TestCase
{
    public function testFindsValidErc20Address(): void
    {
        $probe = new UsdcErc20AddressProbe();

        $text = 'My ERC20 address: 0xAb5801a7D398351b8bE11C439e05C5B3259aec9B';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0xAb5801a7D398351b8bE11C439e05C5B3259aec9B', $results[0]->getResult());
        $this->assertEquals(18, $results[0]->getStart());
        $this->assertEquals(60, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ERC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleErc20Addresses(): void
    {
        $probe = new UsdcErc20AddressProbe();

        $text = 'Addresses: 0xAb5801a7D398351b8bE11C439e05C5B3259aec9B and 0xde0B295669a9FD93d5F28D9Ec85E40f4cb697BAe';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('0xAb5801a7D398351b8bE11C439e05C5B3259aec9B', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(53, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ERC20_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('0xde0B295669a9FD93d5F28D9Ec85E40f4cb697BAe', $results[1]->getResult());
        $this->assertEquals(58, $results[1]->getStart());
        $this->assertEquals(100, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ERC20_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidShortAddress(): void
    {
        $probe = new UsdcErc20AddressProbe();

        $text = 'Too short: 0x1234567890abcdef';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresInvalidLongAddress(): void
    {
        $probe = new UsdcErc20AddressProbe();

        $text = 'Too long: 0x1234567890abcdef1234567890abcdef1234567890abcdef';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsLowercaseAddress(): void
    {
        $probe = new UsdcErc20AddressProbe();

        $text = 'Lowercase: 0xab5801a7d398351b8be11c439e05c5b3259aec9b';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0xab5801a7d398351b8be11c439e05c5b3259aec9b', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(53, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ERC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new UsdcErc20AddressProbe();

        $text = 'Send to ERC20: 0xAb5801a7D398351b8bE11C439e05C5B3259aec9B.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0xAb5801a7D398351b8bE11C439e05C5B3259aec9B', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(57, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ERC20_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresCompletelyInvalidString(): void
    {
        $probe = new UsdcErc20AddressProbe();

        $text = 'Random string: 0xGHIJK12345ABCDE67890';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
