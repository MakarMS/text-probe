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
