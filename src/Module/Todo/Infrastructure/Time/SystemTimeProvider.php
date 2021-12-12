<?php

declare(strict_types = 1);

namespace App\Module\Todo\Infrastructure\Time;

use App\Module\Todo\Domain\TimeProvider;
use DateTimeImmutable;
use DateTimeInterface;

final class SystemTimeProvider implements TimeProvider
{
    public function now(): DateTimeInterface
    {
        return new DateTimeImmutable();
    }
}
