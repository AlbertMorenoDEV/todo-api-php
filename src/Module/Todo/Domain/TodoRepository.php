<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

interface TodoRepository
{
    public function save(Todo $todo): void;

    public function find(Id $id): Todo;
}
