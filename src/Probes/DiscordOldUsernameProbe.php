<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

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