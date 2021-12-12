<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

use DateTimeInterface;

interface TimeProvider
{
    public function now(): DateTimeInterface;
}
