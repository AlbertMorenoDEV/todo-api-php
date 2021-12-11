<?php

declare(strict_types = 1);

namespace App\Module\Todo\Application\Create;

use App\Module\Todo\Domain\DueTime;
use App\Module\Todo\Domain\Id;
use App\Module\Todo\Domain\Title;
use App\Module\Todo\Domain\Todo;
use App\Module\Todo\Domain\TodoRepository;
use App\Shared\Application\Command;
use App\Shared\Application\CommandHandler;

final class CreateTodoCommandHandler implements CommandHandler
{
    public function __construct(private TodoRepository $todoRepository)
    {
    }

    public function __invoke(CreateTodoCommand|Command $command): void
    {
        $newTodo = Todo::create(
            Id::fromString($command->id()),
            Title::fromString($command->title()),
            DueTime::fromInteger($command->dueTime())
        );

        $this->todoRepository->save($newTodo);
    }
}
