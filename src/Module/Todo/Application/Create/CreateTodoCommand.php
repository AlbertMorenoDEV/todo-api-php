<?php

declare(strict_types = 1);

namespace App\Module\Todo\Application\Create;

final class CreateTodoCommand
{
    public function __construct(private string $id, private string $title, private int $dueTime)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function dueTime(): int
    {
        return $this->dueTime;
    }
}
