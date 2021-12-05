<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\Id;
use App\Module\Todo\Domain\InvalidId;
use PHPUnit\Framework\TestCase;
use TypeError;

class IdTest extends TestCase
{
    /**
     * @test
     * @dataProvider fromStringFailingCases
     */
    public function itShouldFailCreatingFromString(mixed $input, string $exceptionClass, ?string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);

        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        Id::fromString($input);
    }

    public function fromStringFailingCases(): array
    {
        return [
            'Invalid UUID' => [
                'input'            => 'invalid-id',
                'exceptionClass'   => InvalidId::class,
                'exceptionMessage' => sprintf(InvalidId::INVALID_UUID_MESSAGE, 'invalid-id'),
            ],
            'Empty' => [
                'input'            => '',
                'exceptionClass'   => InvalidId::class,
                'exceptionMessage' => InvalidId::EMPTY_MESSAGE,
            ],
            'Integer' => [
                'input'            => 1,
                'exceptionClass'   => TypeError::class,
                'exceptionMessage' => null,
            ],
        ];
    }
}
