<?php

namespace Tests\Probes\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Account\IbanMaskedProbe;

/**
 * @internal
 */
class IbanMaskedProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new IbanMaskedProbe();

        $expected = 'DE89 **** **** **** 0130 00';
        $text = 'Value: DE89 **** **** **** 0130 00';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::IBAN_MASKED, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new IbanMaskedProbe();

        $expected = 'DE89 **** **** **** 0130 00';
        $text = 'First DE89 **** **** **** 0130 00 then DE89 **** **** **** 0130 00';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::IBAN_MASKED, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(39, $results[1]->getStart());
        $this->assertSame(66, $results[1]->getEnd());
        $this->assertSame(ProbeType::IBAN_MASKED, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new IbanMaskedProbe();

        $text = 'Value: DE89';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new IbanMaskedProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new IbanMaskedProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
