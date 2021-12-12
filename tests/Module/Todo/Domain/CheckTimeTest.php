<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\CheckTime;
use App\Module\Todo\Domain\InvalidCheckTime;
use PHPUnit\Framework\TestCase;
use TypeError;

class CheckTimeTest extends TestCase
{
    /**
     * @test
     * @dataProvider fromIntegerFailingCases
     */
    public function itShouldFailCreatingFromInteger(
        mixed $input,
        string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        $this->expectException($exceptionClass);

        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        CheckTime::fromInteger($input);
    }

    public function fromIntegerFailingCases(): array
    {
        return [
            'Empty'  => [
                'input'            => 0,
                'exceptionClass'   => InvalidCheckTime::class,
                'exceptionMessage' => sprintf(InvalidCheckTime::EMPTY_MESSAGE, 0),
            ],
            'String' => [
                'input'            => '0',
                'exceptionClass'   => TypeError::class,
                'exceptionMessage' => null,
            ],
        ];
    }
}
