<?php

declare(strict_types = 1);

namespace App\Module\Todo\Application\Update;

final class MarkTodoAsDoneCommand
{
    public function __construct(private string $id, private int $checkTime)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function checkTime(): int
    {
        return $this->checkTime;
    }
}
