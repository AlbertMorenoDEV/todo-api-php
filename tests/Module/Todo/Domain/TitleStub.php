<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\Title;

final class TitleStub
{
    private static array $titleExamples = [
        'Buy bread',
        'Empty the bins',
        'Pay the rent',
        'Call dad',
        'Turn off the heater',
    ];

    public static function random(): Title
    {
        return Title::fromString(self::$titleExamples[array_rand(self::$titleExamples)]);
    }
}
