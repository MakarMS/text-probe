<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

class DiscordNewUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![a-z0-9_@])@(?=[a-z0-9_.]{2,32}\b)(?!.*\.\.)[a-z0-9_]+(?:\.[a-z0-9_]+)*(?=[\s.,!?]|$)/i', $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DISCORD_NEW_USERNAME;
    }
}