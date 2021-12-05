<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\DueTime;
use App\Module\Todo\Domain\InvalidDueTime;
use PHPUnit\Framework\TestCase;
use TypeError;

class DueTimeTest extends TestCase
{
    /**
     * @test
     * @dataProvider fromIntegerFailingCases
     */
    public function itShouldFailCreatingFromInteger(mixed $input, string $exceptionClass, ?string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);

        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        DueTime::fromInteger($input);
    }

    public function fromIntegerFailingCases(): array
    {
        return [
            'Empty' => [
                'input'            => 0,
                'exceptionClass'   => InvalidDueTime::class,
                'exceptionMessage' => sprintf(InvalidDueTime::EMPTY_MESSAGE, 0),
            ],
            'String' => [
                'input'            => '0',
                'exceptionClass'   => TypeError::class,
                'exceptionMessage' => null,
            ],
        ];
    }
}
