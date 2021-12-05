<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\InvalidTitle;
use App\Module\Todo\Domain\Title;
use PHPUnit\Framework\TestCase;
use TypeError;

class TitleTest extends TestCase
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

        Title::fromString($input);
    }

    public function fromStringFailingCases(): array
    {
        return [
            'Empty' => [
                'input'            => '',
                'exceptionClass'   => InvalidTitle::class,
                'exceptionMessage' => InvalidTitle::EMPTY_MESSAGE,
            ],
            'Too Long' => [
                'input'            => 'This title is longer than the 50 maximum characters allowed',
                'exceptionClass'   => InvalidTitle::class,
                'exceptionMessage' => InvalidTitle::TOO_LONG_MESSAGE,
            ],
            'Integer' => [
                'input'            => 1,
                'exceptionClass'   => TypeError::class,
                'exceptionMessage' => null,
            ],
        ];
    }
}
