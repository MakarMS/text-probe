<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GoogleServiceAccountEmailProbe;

/**
 * @internal
 */
class GoogleServiceAccountEmailProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $expected = 'service-account@project-id.iam.gserviceaccount.com';
        $text = 'service-account@project-id.iam.gserviceaccount.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $expected = 'name.with-dash@my-project-123.iam.gserviceaccount.com';
        $text = 'name.with-dash@my-project-123.iam.gserviceaccount.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $first = 'service-account@project-id.iam.gserviceaccount.com';
        $second = 'name.with-dash@my-project-123.iam.gserviceaccount.com';
        $text = 'service-account@project-id.iam.gserviceaccount.com' . "\n" . 'name.with-dash@my-project-123.iam.gserviceaccount.com';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(51, $results[1]->getStart());
        $this->assertSame(104, $results[1]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $expected = 'service-account@project-id.iam.gserviceaccount.com';
        $text = 'service-account@project-id.iam.gserviceaccount.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $expected = 'service-account@project-id.iam.gserviceaccount.com';
        $text = 'service-account@project-id.iam.gserviceaccount.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $expected = 'service-account@project-id.iam.gserviceaccount.com';
        $text = 'service-account@project-id.iam.gserviceaccount.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $text = 'user@example.com';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new GoogleServiceAccountEmailProbe();

        $expected = 'service-account@project-id.iam.gserviceaccount.com';
        $text = 'service-account@project-id.iam.gserviceaccount.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL, $results[0]->getProbeType());
    }
}
