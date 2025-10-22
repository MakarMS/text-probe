<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class DiscordOldUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\S)[^\s#]{2,32}#\d{4}(?!\S)/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DISCORD_OLD_USERNAME;
    }
}
