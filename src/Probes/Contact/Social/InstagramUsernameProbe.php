<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Instagram usernames (e.g., "@username").
 *
 * The probe enforces Instagram handle rules: allows letters, digits,
 * underscores and dots, forbids consecutive dots, limits length to 30
 * characters (excluding the leading "@"), and requires a valid boundary so
 * emails and embedded strings are ignored.
 */
class InstagramUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![A-Za-z0-9_.@])@'
            . '(?=[A-Za-z0-9_.]{1,30}(?=$|[\s,!?]|\.(?![A-Za-z0-9_.])))'
            . '[A-Za-z0-9_](?:[A-Za-z0-9_]|\.(?=[A-Za-z0-9_]))*'
            . '(?=$|[\s,!?]|\.(?![A-Za-z0-9_.]))/i',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::INSTAGRAM_USERNAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::INSTAGRAM_USERNAME;
    }
}
