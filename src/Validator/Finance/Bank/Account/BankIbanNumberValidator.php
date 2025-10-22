<?php

namespace TextProbe\Validator\Finance\Bank\Account;

use TextProbe\Validator\Contracts\IValidator;

class BankIbanNumberValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $iban = $this->normalize($raw);

        if ($iban === '' || !$this->hasValidFormat($iban)) {
            return false;
        }

        return $this->checkMod97($iban);
    }

    private function normalize(string $iban): string
    {
        return strtoupper(str_replace(' ', '', trim($iban)));
    }

    private function hasValidFormat(string $iban): bool
    {
        return (bool)preg_match('/^[A-Z]{2}\d{2}[A-Z0-9]{10,30}$/', $iban);
    }

    private function checkMod97(string $iban): bool
    {
        $rearranged = substr($iban, 4) . substr($iban, 0, 4);
        $mod97 = 0;

        foreach (str_split($rearranged) as $char) {
            $mod97 = $this->processChar($mod97, $char);
        }

        return $mod97 === 1;
    }

    // Specially implemented without extensions
    private function processChar(int $mod97, string $char): int
    {
        if ($char >= '0' && $char <= '9') {
            return ($mod97 * 10 + (int)$char) % 97;
        }

        $numericValue = ord($char) - 55;
        foreach (str_split((string)$numericValue) as $digitChar) {
            $mod97 = ($mod97 * 10 + (int)$digitChar) % 97;
        }

        return $mod97;
    }
}
