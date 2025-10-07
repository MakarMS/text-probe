<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\BitcoinAddressProbe;

class BitcoinAddressProbeTest extends TestCase
{
    public function testFindsP2PKHAddress(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "BTC address: 1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(47, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsP2SHAddress(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "Send BTC to 3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(46, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsBech32Address(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "Bech32 address: bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(58, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleAddresses(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "Multiple: 1BoatSLRHtKNngkdXEeobR76b53LETtpyT and 3Ai1JZ8pdJb2ksieUV8FsxSNVJCpoPi8W6";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('1BoatSLRHtKNngkdXEeobR76b53LETtpyT', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(44, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('3Ai1JZ8pdJb2ksieUV8FsxSNVJCpoPi8W6', $results[1]->getResult());
        $this->assertEquals(49, $results[1]->getStart());
        $this->assertEquals(83, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidAddresses(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "Invalid: 1InvalidBTCAddr and bc1xyz123";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsLowercaseBech32Address(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "Lowercase bech32: bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kygt080";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kygt080', $results[0]->getResult());
        $this->assertEquals(18, $results[0]->getStart());
        $this->assertEquals(60, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsAddressesMixedCase(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "Mixed: 1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa and 3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(41, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy', $results[1]->getResult());
        $this->assertEquals(46, $results[1]->getStart());
        $this->assertEquals(80, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[1]->getProbeType());
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new BitcoinAddressProbe();

        $text = "BTC address: 3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy,";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(47, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_BITCOIN_ADDRESS, $results[0]->getProbeType());
    }
}
