<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\DueTime;
use Exception;

final class DueTimeStub
{
    /**
     * @throws Exception
     */
    public static function future(): DueTime
    {
        return DueTime::fromInteger(strtotime( '+'.random_int(1, 30).' days'));
    }
}
