<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Aba Routing Masked values from text.
 *
 * Examples:
 * - valid: `*****6789`
 * - invalid: `***6789`
 *
 * Constraints:
 * - Uses regex pattern `/(?<!\S)\*{5}\d{4}(?!\S)/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AbaRoutingMaskedProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\S)\*{5}\d{4}(?!\S)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ABA_ROUTING_MASKED
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ABA_ROUTING_MASKED;
    }
}
