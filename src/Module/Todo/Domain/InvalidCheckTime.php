<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

use DomainException;

final class InvalidCheckTime extends DomainException
{
    public const EMPTY_MESSAGE = 'Check time <%s> received value is not valid.';

    public static function invalid(int $value): self
    {
        return new self(sprintf(self::EMPTY_MESSAGE, $value));
    }
}
