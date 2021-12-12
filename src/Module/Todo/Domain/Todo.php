<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

final class Todo
{
    private function __construct(private Id $id, private Title $title, private DueTime $dueTime)
    {
    }

    public static function create(Id $id, Title $title, DueTime $dueTime): self
    {
        return new self($id, $title, $dueTime);
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function dueTime(): DueTime
    {
        return $this->dueTime;
    }

    public function markAsDone(CheckTime $checkTime): void
    {

    }
}
