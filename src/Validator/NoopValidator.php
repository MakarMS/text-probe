<?php

namespace TextProbe\Validator;

use TextProbe\Validator\Contracts\IValidator;

class NoopValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        return true;
    }
}