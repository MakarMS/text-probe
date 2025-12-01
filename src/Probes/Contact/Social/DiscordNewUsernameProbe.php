<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Discord usernames in the new global format (e.g. "@username").
 *
 * This probe enforces Discord’s updated username rules, including allowed characters,
 * length limits and prevention of consecutive dots in the name.
 */
class DiscordNewUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![a-z0-9_@])@(?=[a-z0-9_.]{2,32}\b)(?!.*\.\.)[a-z0-9_]+(?:\.[a-z0-9_]+)*(?=[\s.,!?]|$)/i',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DISCORD_NEW_USERNAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DISCORD_NEW_USERNAME;
    }
}
