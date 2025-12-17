<?php

namespace Tests\Probes\Contact;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\RussianInnProbe;
use TextProbe\Validator\Contracts\IValidator;

/**
 * @internal
 */
class RussianInnProbeTest extends TestCase
{
    public function testFindsValidLegalEntityInn(): void
    {
        $probe = new RussianInnProbe();

        $text = 'INN 7707083893 belongs to ACME';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertSame('7707083893', $results[0]->getResult());
        $this->assertSame(mb_strpos($text, '7707083893'), $results[0]->getStart());
        $this->assertSame(mb_strpos($text, '7707083893') + 10, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUSSIAN_INN, $results[0]->getProbeType());
    }

    public function testFindsValidIndividualInn(): void
    {
        $probe = new RussianInnProbe();

        $text = 'Citizen INN is 500100732259 in the registry.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertSame('500100732259', $results[0]->getResult());
        $this->assertSame(mb_strpos($text, '500100732259'), $results[0]->getStart());
        $this->assertSame(mb_strpos($text, '500100732259') + 12, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUSSIAN_INN, $results[0]->getProbeType());
    }

    public function testReturnsBothInnTypesFromText(): void
    {
        $probe = new RussianInnProbe();

        $text = 'Valid list: 500100732259 and 7707083893 inside.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame('500100732259', $results[0]->getResult());
        $this->assertSame(ProbeType::RUSSIAN_INN, $results[0]->getProbeType());

        $this->assertSame('7707083893', $results[1]->getResult());
        $this->assertSame(ProbeType::RUSSIAN_INN, $results[1]->getProbeType());
    }

    public function testSkipsInnWithInvalidChecksum(): void
    {
        $probe = new RussianInnProbe();

        $text = 'Fake INN 7707083890 should not pass validation.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testCustomValidatorIsUsed(): void
    {
        $validator = new class () implements IValidator {
            public function validate(string $raw): bool
            {
                return strlen($raw) === 10;
            }
        };

        $probe = new RussianInnProbe($validator);

        $text = 'Mixed values 500100732259 and 1234567890.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('1234567890', $results[0]->getResult());
    }
}
