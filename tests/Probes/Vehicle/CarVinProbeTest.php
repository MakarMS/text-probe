<?php

namespace Tests\Probes\Vehicle;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Vehicle\CarVinProbe;
use TextProbe\Validator\Vehicle\CarVinValidator;

/**
 * @internal
 */
class CarVinProbeTest extends TestCase
{
    public function testExtractsValidVin(): void
    {
        $text = 'VIN: 1HGCM82633A004352 was detected';
        $probe = new CarVinProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('1HGCM82633A004352', $results[0]->getResult());
        $this->assertSame(ProbeType::CAR_VIN, $results[0]->getProbeType());
        $this->assertSame(strpos($text, '1HGCM82633A004352'), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + 17, $results[0]->getEnd());
    }

    public function testRejectsInvalidCheckDigit(): void
    {
        $text = 'Invalid VIN 1HGCM82634A004352 should not match';
        $probe = new CarVinProbe();

        $this->assertSame([], $probe->probe($text));
    }

    public function testRejectsVinWithForbiddenCharacters(): void
    {
        $text = 'Vehicle number 1HGCM82633A00I352 includes forbidden letter';
        $probe = new CarVinProbe();

        $this->assertSame([], $probe->probe($text));
    }

    public function testExtractsMultipleVins(): void
    {
        $firstVin = '1HGCM82633A004352';
        $secondVin = '1M8GDM9AXKP042788';
        $text = "First: {$firstVin}; Second: {$secondVin}";
        $probe = new CarVinProbe();

        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($firstVin, $results[0]->getResult());
        $this->assertSame($secondVin, $results[1]->getResult());
    }

    public function testValidatesVinWithXCheckDigit(): void
    {
        $validator = new CarVinValidator();

        $this->assertTrue($validator->validate('1M8GDM9AXKP042788'));
    }
}
