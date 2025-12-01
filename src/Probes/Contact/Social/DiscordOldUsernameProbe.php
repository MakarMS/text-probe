<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts classic Discord usernames in the "username#1234" format.
 *
 * This probe validates the discriminator part (4 digits) and enforces the expected
 * structure of legacy Discord usernames.
 */
class DiscordOldUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\S)[^\s#]{2,32}#\d{4}(?!\S)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DISCORD_OLD_USERNAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DISCORD_OLD_USERNAME;
    }
}
