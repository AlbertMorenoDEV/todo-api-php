<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

use DomainException;

final class InvalidTitle extends DomainException
{
    public const EMPTY_MESSAGE    = 'Title can not be empty.';
    public const TOO_LONG_MESSAGE = 'Title can not be longer than 50 characters.';

    public static function empty(): self
    {
        return new self(self::EMPTY_MESSAGE);
    }

    public static function tooLong(): self
    {
        return new self(self::TOO_LONG_MESSAGE);
    }
}
