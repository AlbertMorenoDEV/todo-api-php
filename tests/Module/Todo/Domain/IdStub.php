<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\Id;
use Ramsey\Uuid\Uuid;

final class IdStub
{
    public static function random(): Id
    {
        return Id::fromString(Uuid::uuid4()->toString());
    }
}
