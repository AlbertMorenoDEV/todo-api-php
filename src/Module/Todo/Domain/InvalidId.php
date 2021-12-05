<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

use DomainException;

final class InvalidId extends DomainException
{
    public const EMPTY_MESSAGE        = 'Todo ID needs to have some UUID valid value.';
    public const INVALID_UUID_MESSAGE = 'Todo ID needs to be a valid UUID string. <%s> received value is not valid.';

    public static function empty(): self
    {
        return new self(self::EMPTY_MESSAGE);
    }

    public static function invalidUuidFormat(string $value): self
    {
        return new self(sprintf(self::INVALID_UUID_MESSAGE, $value));
    }
}
