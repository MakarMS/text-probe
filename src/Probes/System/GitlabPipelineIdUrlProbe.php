<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts GitLab pipeline URLs.
 */
class GitlabPipelineIdUrlProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^https:\/\/gitlab\.com\/[A-Za-z0-9_.\/-]+\/pipelines\/\d+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITLAB_PIPELINE_ID_URL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITLAB_PIPELINE_ID_URL;
    }
}
