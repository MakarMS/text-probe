<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Bank Card Masked values from text.
 *
 * Examples:
 * - valid: `**** **** **** 4242`
 * - invalid: `**** **** **** ****`
 *
 * Constraints:
 * - Uses regex pattern `/(?<!\S)(?:\*{4}[- ]?){3}\d{4}(?!\S)/`.
 * - Relies on regex filtering only (no additional validator).
 */
class BankCardMaskedProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\S)(?:\*{4}[- ]?){3}\d{4}(?!\S)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_CARD_MASKED
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_CARD_MASKED;
    }
}
