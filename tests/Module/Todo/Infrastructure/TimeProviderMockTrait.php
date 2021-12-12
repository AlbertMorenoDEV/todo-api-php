<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Infrastructure;

use App\Module\Todo\Domain\TimeProvider;
use DateTimeInterface;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

trait TimeProviderMockTrait
{
    private LegacyMockInterface|MockInterface|TimeProvider $timeProviderMock;

    protected function timeProviderMock(): TimeProvider|MockInterface|LegacyMockInterface
    {
        return $this->timeProviderMock = $this->timeProviderMock ?? Mockery::mock(TimeProvider::class);
    }

    protected function shouldGetNow(DateTimeInterface $now): void
    {
        $this->timeProviderMock()
             ->expects('now')
             ->once()
             ->andReturn($now);
    }
}
