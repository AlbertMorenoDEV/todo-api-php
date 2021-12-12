<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\Id;
use Closure;

final class IdConstraint
{
    public static function equalsTo(Id $expected): Closure
    {
        return static function (Id $received) use ($expected) {
            return $expected->isEqualsTo($received);
        };
    }
}
