<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\CheckTime;

final class CheckTimeStub
{
    /**
     * @throws Exception
     */
    public static function now(): CheckTime
    {
        return CheckTime::fromInteger(time());
    }
}
