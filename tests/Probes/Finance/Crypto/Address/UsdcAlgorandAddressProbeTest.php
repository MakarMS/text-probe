<?php

namespace Tests\Probes\Finance\Crypto\Address;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\Address\UsdcAlgorandAddressProbe;

/**
 * @internal
 */
class UsdcAlgorandAddressProbeTest extends TestCase
{
    public function testFindsValidAlgorandAddress(): void
    {
        $probe = new UsdcAlgorandAddressProbe();

        $text = 'My Algorand address: 6BJ32SU3ABLWSBND7U5H2QICQ6GGXVD7AXSSMRYM2GO3RRNHCZIUT4ISAQ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6BJ32SU3ABLWSBND7U5H2QICQ6GGXVD7AXSSMRYM2GO3RRNHCZIUT4ISAQ', $results[0]->getResult());
        $this->assertEquals(21, $results[0]->getStart());
        $this->assertEquals(79, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ALGORAND_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleAlgorandAddresses(): void
    {
        $probe = new UsdcAlgorandAddressProbe();

        $text = 'Addresses: 6BJ32SU3ABLWSBND7U5H2QICQ6GGXVD7AXSSMRYM2GO3RRNHCZIUT4ISAQ and NJY27OQ2ZXK6OWBN44LE4K43TA2AV3DPILPYTHAJAMKIVZDWTEJKZJKO4A';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('6BJ32SU3ABLWSBND7U5H2QICQ6GGXVD7AXSSMRYM2GO3RRNHCZIUT4ISAQ', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(69, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ALGORAND_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('NJY27OQ2ZXK6OWBN44LE4K43TA2AV3DPILPYTHAJAMKIVZDWTEJKZJKO4A', $results[1]->getResult());
        $this->assertEquals(74, $results[1]->getStart());
        $this->assertEquals(132, $results[1]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ALGORAND_ADDRESS, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidShortAddress(): void
    {
        $probe = new UsdcAlgorandAddressProbe();

        $text = 'Too short: S3F5J6K7L8M9N0P1Q2R3S4T5U6V7W8X9Y0Z1A2B3C4D5E6F7G8H9J0K1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresInvalidLongAddress(): void
    {
        $probe = new UsdcAlgorandAddressProbe();

        $text = 'Too long: S3F5J6K7L8M9N0P1Q2R3S4T5U6V7W8X9Y0Z1A2B3C4D5E6F7G8H9J0K1L2M3N4';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresLowercaseAddress(): void
    {
        $probe = new UsdcAlgorandAddressProbe();

        $text = 'Lowercase: s3f5j6k7l8m9n0p1q2r3s4t5u6v7w8x9y0z1a2b3c4d5e6f7g8h9j0k1l2m3';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testTrimsTrailingPunctuation(): void
    {
        $probe = new UsdcAlgorandAddressProbe();

        $text = 'Send to Algorand: NJY27OQ2ZXK6OWBN44LE4K43TA2AV3DPILPYTHAJAMKIVZDWTEJKZJKO4A.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('NJY27OQ2ZXK6OWBN44LE4K43TA2AV3DPILPYTHAJAMKIVZDWTEJKZJKO4A', $results[0]->getResult());
        $this->assertEquals(18, $results[0]->getStart());
        $this->assertEquals(76, $results[0]->getEnd());
        $this->assertEquals(ProbeType::CRYPTO_USDC_ALGORAND_ADDRESS, $results[0]->getProbeType());
    }

    public function testIgnoresCompletelyInvalidString(): void
    {
        $probe = new UsdcAlgorandAddressProbe();

        $text = 'Random string: ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
