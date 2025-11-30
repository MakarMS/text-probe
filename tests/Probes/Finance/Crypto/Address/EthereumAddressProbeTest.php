<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\EthereumAddressProbe;

/**
 * @internal
 */
class EthereumAddressProbeTest extends TestCase
{
    public function testFindsValidAddress(): void
    {
        $probe = new EthereumAddressProbe();

        $text = 'ETH address: 0x742d35Cc6634C0532925a3b844Bc454e4438f44e';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0x742d35Cc6634C0532925a3b844Bc454e4438f44e', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(55, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsLowercaseAddress(): void
    {
        $probe = new EthereumAddressProbe();

        $text = 'Lowercase: 0x742d35cc6634c0532925a3b844bc454e4438f44e';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0x742d35cc6634c0532925a3b844bc454e4438f44e', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(53, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsUppercaseAddress(): void
    {
        $probe = new EthereumAddressProbe();

        $text = 'Uppercase: 0X742D35CC6634C0532925A3B844BC454E4438F44E';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0X742D35CC6634C0532925A3B844BC454E4438F44E', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(53, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleAddresses(): void
    {
        $probe = new EthereumAddressProbe();

        $text = 'ETH: 0x742d35Cc6634C0532925a3b844Bc454e4438f44e and 0x53d284357ec70cE289D6D64134DfAc8E511c8a3D';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('0x742d35Cc6634C0532925a3b844Bc454e4438f44e', $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(47, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('0x53d284357ec70cE289D6D64134DfAc8E511c8a3D', $results[1]->getResult());
        $this->assertEquals(52, $results[1]->getStart());
        $this->assertEquals(94, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidAddress(): void
    {
        $probe = new EthereumAddressProbe();

        // 1 char short
        $text = 'Invalid ETH: 0x742d35Cc6634C0532925a3b844Bc454e4438f44';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresNonHexCharacters(): void
    {
        $probe = new EthereumAddressProbe();

        $text = 'Non-hex: 0xG42d35Cc6634C0532925a3b844Bc454e4438f44e';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMixedCaseAddresses(): void
    {
        $probe = new EthereumAddressProbe();

        $text = 'Mixed: 0x742d35Cc6634C0532925a3b844Bc454e4438f44e and 0X53D284357EC70CE289D6D64134DFAC8E511C8A3D';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('0x742d35Cc6634C0532925a3b844Bc454e4438f44e', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(49, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('0X53D284357EC70CE289D6D64134DFAC8E511C8A3D', $results[1]->getResult());
        $this->assertEquals(54, $results[1]->getStart());
        $this->assertEquals(96, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[1]->getProbeType());
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new EthereumAddressProbe();

        $text = 'ETH address: 0x742d35Cc6634C0532925a3b844Bc454e4438f44e,';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('0x742d35Cc6634C0532925a3b844Bc454e4438f44e', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(55, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_ETHEREUM_ADDRESS, $results[0]->getProbeType());
    }
}
