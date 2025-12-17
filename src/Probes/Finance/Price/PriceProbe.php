<?php

namespace TextProbe\Probes\Finance\Price;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Price\PriceValidator;

/**
 * Probe that extracts price expressions combining numeric amounts with
 * currency symbols or ISO currency codes.
 *
 * Supported examples include prefixed symbols (e.g. "$199"), suffixed symbols
 * (e.g. "1 500₽"), ISO codes (e.g. "100 USD"), and slash-delimited currency
 * pairs (e.g. "99 EUR/UAH"). Thousand separators with spaces or commas and
 * decimal fractions using dots or commas are recognised.
 */
class PriceProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to refine or
     *                                   override currency detection. Defaults
     *                                   to {@see PriceValidator}.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new PriceValidator());
    }

    public function probe(string $text): array
    {
        $currencySymbols = '[$€£¥₽₴₹₺₼₾₫₦₵₲₱฿₸₡₨]';
        $amountPattern = '(?:\d{1,3}(?:[\s,]\d{3})*|\d+)(?:[.,]\d+)?';
        $codePattern = '[A-Z]{3}(?:\/[A-Z]{3})*(?![A-Za-z])';

        $pattern = '/('
            . $currencySymbols . '\s*' . $amountPattern . '(?:\s*(?:' . $currencySymbols . '|' . $codePattern . '))?'
            . '|' . $amountPattern . '\s*(?:' . $currencySymbols . '|' . $codePattern . ')'
            . ')/iu';

        return $this->findByRegex($pattern, $text);
    }

    /**
     * @return ProbeType returns ProbeType::PRICE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PRICE;
    }
}
