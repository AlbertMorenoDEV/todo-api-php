<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

use DomainException;

final class TodoNotFound extends DomainException
{
    public const WITH_ID_MESSAGE = 'Todo with id <%s> does not exist.';

    public static function withId(Id $id): self
    {
        return new self(sprintf(self::WITH_ID_MESSAGE, $id->value()));
    }
}
