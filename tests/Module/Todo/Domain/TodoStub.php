<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Domain;

use App\Module\Todo\Domain\CheckTime;
use App\Module\Todo\Domain\DueTime;
use App\Module\Todo\Domain\Id;
use App\Module\Todo\Domain\Title;
use App\Module\Todo\Domain\Todo;

final class TodoStub
{
    public static function newDone(Id $id, Title $title, DueTime $dueTime, CheckTime $checkTime): Todo
    {
        $newTodo = Todo::create($id, $title, $dueTime);
        $newTodo->markAsDone($checkTime);

        return $newTodo;
    }

    public static function randomPendingWithId(Id $id): Todo
    {
        return Todo::create($id, TitleStub::random(), DueTimeStub::future());
    }
}
