<?php

namespace Tests\Probes\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Account\BankBicCodeProbe;

/**
 * @internal
 */
class BankBicCodeProbeTest extends TestCase
{
    public function testFindsPlainBic(): void
    {
        $probe = new BankBicCodeProbe();

        $text = 'My BIC is DEUTDEFF500';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('DEUTDEFF500', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(21, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_BIC_CODE, $results[0]->getProbeType());
    }

    public function testFindsBicWithoutBranchCode(): void
    {
        $probe = new BankBicCodeProbe();

        $text = 'BIC: NEDSZAJJ';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('NEDSZAJJ', $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_BIC_CODE, $results[0]->getProbeType());
    }

    public function testFindsMultipleBics(): void
    {
        $probe = new BankBicCodeProbe();

        $text = 'BIC codes: DEUTDEFF500, NEDSZAJJ';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('DEUTDEFF500', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_BIC_CODE, $results[0]->getProbeType());

        $this->assertEquals('NEDSZAJJ', $results[1]->getResult());
        $this->assertEquals(24, $results[1]->getStart());
        $this->assertEquals(32, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_BIC_CODE, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidBic(): void
    {
        $probe = new BankBicCodeProbe();

        $text = 'Invalid BIC: DEUT1234';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresShortBic(): void
    {
        $probe = new BankBicCodeProbe();

        $text = 'Short BIC: ABCD';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsBicWithLowercase(): void
    {
        $probe = new BankBicCodeProbe();

        $text = 'Lowercase bic: deutdeff500';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('deutdeff500', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_BIC_CODE, $results[0]->getProbeType());
    }
}
