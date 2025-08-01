<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

class TelegramUserLinkProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/https?:\/\/(?:t\.me|telegram\.me|telegram\.dog)\/[a-zA-Z0-9_]{5,32}(?:[?#]\S*)?/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TELEGRAM_USER_LINK;
    }
}