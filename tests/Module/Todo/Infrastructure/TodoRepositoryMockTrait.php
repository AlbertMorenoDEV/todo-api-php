<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Infrastructure;

use App\Module\Todo\Domain\Id;
use App\Module\Todo\Domain\Todo;
use App\Module\Todo\Domain\TodoRepository;
use App\Tests\Module\Todo\Domain\IdConstraint;
use App\Tests\Module\Todo\Domain\TodoConstraint;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

trait TodoRepositoryMockTrait
{
    private LegacyMockInterface|MockInterface|TodoRepository $todoRepositoryMock;

    protected function todoRepositoryMock(): TodoRepository|MockInterface|LegacyMockInterface
    {
        return $this->todoRepositoryMock = $this->todoRepositoryMock ?? Mockery::mock(TodoRepository::class);
    }

    protected function shouldFindTodo(Id $id, Todo $todo): void
    {
        $this->todoRepositoryMock()
             ->expects('find')
             ->with(Mockery::on(IdConstraint::equalsTo($id)))
             ->once()
             ->andReturn($todo);
    }

    protected function shouldSaveTodo(Todo $todo): void
    {
        $this->todoRepositoryMock()
             ->expects('save')
             ->once()
             ->with(Mockery::on(TodoConstraint::equalsTo($todo)));
    }
}
