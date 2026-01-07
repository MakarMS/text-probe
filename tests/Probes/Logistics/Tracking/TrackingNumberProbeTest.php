<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\TrackingNumberProbe;

/**
 * @internal
 */
class TrackingNumberProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('trackingNumberSamples')]
    public function testFindsMatchesInExpectedOrder(string $text, array $expected): void
    {
        $probe = new TrackingNumberProbe();

        $results = $probe->probe($text);

        $this->assertCount(count($expected), $results);

        foreach ($expected as $index => $value) {
            $this->assertSame($value, $results[$index]->getResult());
            $this->assertSame(ProbeType::TRACKING_NUMBER, $results[$index]->getProbeType());
        }
    }

    public function testFindsTrackingNumberAtStart(): void
    {
        $probe = new TrackingNumberProbe();
        $trackingNumber = TrackingTestHelper::makeUps1Z('1Z12345E020527168');

        $text = $trackingNumber . "\nSHIPPED";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::TRACKING_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsTrackingNumberAtEnd(): void
    {
        $probe = new TrackingNumberProbe();
        $trackingNumber = TrackingTestHelper::makeS10('RA', '12345678', 'US');

        $text = "HEADER\n" . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::TRACKING_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsTrackingNumberWithPunctuation(): void
    {
        $probe = new TrackingNumberProbe();
        $trackingNumber = '12345678901234567890';

        $text = "FEDEX\n" . $trackingNumber . "\nDELIVERED";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::TRACKING_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsTrackingNumberInParentheses(): void
    {
        $probe = new TrackingNumberProbe();
        $trackingNumber = '123456789012';

        $text = "START\n" . $trackingNumber . "\nEND";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::TRACKING_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleTrackingNumbers(): void
    {
        $probe = new TrackingNumberProbe();
        $ups = TrackingTestHelper::makeUps1Z('1Z12345E020527168');
        $dpd = '12345678901234';

        $text = $ups . "\n" . $dpd;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($ups, $results[0]->getResult());
        $this->assertSame(strpos($text, $ups), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($ups), $results[0]->getEnd());

        $this->assertSame($dpd, $results[1]->getResult());
        $this->assertSame(strpos($text, $dpd), $results[1]->getStart());
        $this->assertSame($results[1]->getStart() + strlen($dpd), $results[1]->getEnd());
    }

    public function testFindsDuplicateTrackingNumbers(): void
    {
        $probe = new TrackingNumberProbe();
        $trackingNumber = '1234567890';

        $text = $trackingNumber . "\n" . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstPos = strpos($text, $trackingNumber);
        $secondPos = strpos($text, $trackingNumber, $firstPos + 1);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame($firstPos, $results[0]->getStart());
        $this->assertSame($firstPos + strlen($trackingNumber), $results[0]->getEnd());

        $this->assertSame($trackingNumber, $results[1]->getResult());
        $this->assertSame($secondPos, $results[1]->getStart());
        $this->assertSame($secondPos + strlen($trackingNumber), $results[1]->getEnd());
    }

    public function testIgnoresInvalidTrackingText(): void
    {
        $probe = new TrackingNumberProbe();

        $text = 'Nothing to track here';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresShortNumericToken(): void
    {
        $probe = new TrackingNumberProbe();

        $text = 'Short 12345 code';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsHermesTrackingNumber(): void
    {
        $probe = new TrackingNumberProbe();
        $trackingNumber = 'H1234567890';

        $text = "HERMES\n" . $trackingNumber . "\nSTATUS";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::TRACKING_NUMBER, $results[0]->getProbeType());
    }

    public static function trackingNumberSamples(): array
    {
        $ups = TrackingTestHelper::makeUps1Z('1Z12345E020527168');
        $uspsS10 = TrackingTestHelper::makeS10('RA', '12345678', 'US');
        $royalMail = TrackingTestHelper::makeS10('RM', '87654321', 'GB');
        $correos = TrackingTestHelper::makeS10('CE', '23456789', 'ES');
        $postNord = TrackingTestHelper::makeS10('PN', '98765432', 'SE');
        $bpost = TrackingTestHelper::makeS10('BP', '13579135', 'BE');
        $swissPost = TrackingTestHelper::makeS10('CH', '24680246', 'CH');
        $posteItaliane = TrackingTestHelper::makeS10('PI', '10293847', 'IT');
        $russiaPost = TrackingTestHelper::makeS10('RA', '00000000', 'RU');

        $fedex12 = '123456789012';
        $fedex15 = '123456789012345';
        $fedex20 = '12345678901234567890';
        $usps20 = '92055901649173141010';
        $usps22 = '9205590164917314101012';
        $dhl10 = '1234567890';
        $dpd = '12345678901234';
        $gls = '12345678901';
        $hermes = 'H1234567890';
        $postnl = '3S1234567890123';

        return [
            [$fedex12 . "\n" . $uspsS10, [$uspsS10, $fedex12]],
            [$dhl10 . "\n" . $ups, [$ups, $dhl10]],
            [$fedex15 . "\n" . $royalMail . "\n" . $correos, [$royalMail, $correos, $fedex15]],
            [$hermes . "\n" . $postnl . "\n" . $dpd, [$dpd, $hermes, $postnl]],
            [$usps22 . "\n" . $postNord . "\n" . $ups, [$postNord, $ups, $usps22]],
            [$gls . "\n" . $fedex20 . "\n" . $usps20, [$gls, $fedex20, $usps20]],
            [$bpost . "\n" . $swissPost . "\n" . $dhl10, [$bpost, $swissPost, $dhl10]],
            [$russiaPost . "\n" . $ups . "\n" . $fedex12, [$russiaPost, $ups, $fedex12]],
            [$posteItaliane . "\n" . $correos . "\n" . $usps22, [$correos, $posteItaliane, $usps22]],
            [$royalMail . "\n" . $dpd . "\n" . $postnl, [$royalMail, $dpd, $postnl]],
        ];
    }
}
