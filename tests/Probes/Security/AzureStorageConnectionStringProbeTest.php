<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\AzureStorageConnectionStringProbe;

/**
 * @internal
 */
class AzureStorageConnectionStringProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $expected = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $text = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(112, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $expected = 'DefaultEndpointsProtocol=http;AccountName=acct123;AccountKey=abcdefghijklmnopqrstuvwxyz1234567890+/=;EndpointSuffix=core.windows.net';
        $text = 'DefaultEndpointsProtocol=http;AccountName=acct123;AccountKey=abcdefghijklmnopqrstuvwxyz1234567890+/=;EndpointSuffix=core.windows.net';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(132, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $first = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $second = 'DefaultEndpointsProtocol=http;AccountName=acct123;AccountKey=abcdefghijklmnopqrstuvwxyz1234567890+/=;EndpointSuffix=core.windows.net';
        $text = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==' . "\n" . 'DefaultEndpointsProtocol=http;AccountName=acct123;AccountKey=abcdefghijklmnopqrstuvwxyz1234567890+/=;EndpointSuffix=core.windows.net';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(112, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(113, $results[1]->getStart());
        $this->assertSame(245, $results[1]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $expected = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $text = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(112, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $expected = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $text = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(112, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $expected = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $text = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(112, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $text = 'DefaultEndpointsProtocol=https;AccountName=x;AccountKey=short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AzureStorageConnectionStringProbe();

        $expected = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $text = 'DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(112, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_STORAGE_CONNECTION_STRING, $results[0]->getProbeType());
    }
}
