<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts CircleCI workflow UUIDs.
 */
class CircleciWorkflowUuidProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CIRCLECI_WORKFLOW_UUID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CIRCLECI_WORKFLOW_UUID;
    }
}
