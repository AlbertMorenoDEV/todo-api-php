<?php

declare(strict_types = 1);

namespace App\Module\Todo\Application\Update;

use App\Module\Todo\Domain\CheckTime;
use App\Module\Todo\Domain\Id;
use App\Module\Todo\Domain\TimeProvider;
use App\Module\Todo\Domain\TodoRepository;
use App\Shared\Application\Command;
use App\Shared\Application\CommandHandler;

final class MarkTodoAsDoneCommandHandler implements CommandHandler
{
    public function __construct(private TodoRepository $todoRepository, private TimeProvider $timeProvider)
    {
    }

    public function __invoke(MarkTodoAsDoneCommand|Command $command): void
    {
        $todo = $this->todoRepository->find(Id::fromString($command->id()));

        $now = $this->timeProvider->now();
        $todo->markAsDone(CheckTime::fromInteger($now->getTimestamp()));

        $this->todoRepository->save($todo);
    }
}
