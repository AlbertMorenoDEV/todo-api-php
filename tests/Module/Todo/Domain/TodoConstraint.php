<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\Todo;
use Closure;

final class TodoConstraint
{
    public static function equalsTo(Todo $expected): Closure
    {
        return static function (Todo $received) use ($expected) {
            return $expected->id()->isEqualsTo($received->id()) &&
                $expected->title()->isEqualsTo($received->title()) &&
                $expected->dueTime()->isEqualsTo($received->dueTime());
        };
    }
}
