<?php

namespace TextProbe\Validator\Contracts;

interface IValidator
{
    public function validate(string $raw): bool;
}
