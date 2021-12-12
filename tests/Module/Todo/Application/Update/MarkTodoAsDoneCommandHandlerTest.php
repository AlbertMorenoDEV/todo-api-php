<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Application\Update;

use App\Module\Todo\Application\Update\MarkTodoAsDoneCommand;
use App\Module\Todo\Application\Update\MarkTodoAsDoneCommandHandler;
use App\Module\Todo\Domain\Todo;
use App\Tests\Infrastructure\Phpunit\ApplicationTestCase;
use App\Tests\Module\Todo\Domain\CheckTimeStub;
use App\Tests\Module\Todo\Domain\DueTimeStub;
use App\Tests\Module\Todo\Domain\IdStub;
use App\Tests\Module\Todo\Domain\TitleStub;
use App\Tests\Module\Todo\Domain\TodoStub;
use App\Tests\Module\Todo\Infrastructure\TimeProviderMockTrait;
use App\Tests\Module\Todo\Infrastructure\TodoRepositoryMockTrait;

final class MarkTodoAsDoneCommandHandlerTest extends ApplicationTestCase
{
    use TodoRepositoryMockTrait;
    use TimeProviderMockTrait;

    /**
     * @test
     */
    public function itShouldSucceed(): void
    {
        $id           = IdStub::random();
        $title        = TitleStub::random();
        $dueTime      = DueTimeStub::future();
        $checkTime    = CheckTimeStub::now();
        $command      = new MarkTodoAsDoneCommand($id->value());
        $handler      = new MarkTodoAsDoneCommandHandler($this->todoRepositoryMock(), $this->timeProviderMock());
        $initialTodo  = Todo::create($id, $title, $dueTime);
        $expectedTodo = TodoStub::newDone($id, $title, $dueTime, $checkTime);

        $this->shouldGetNow($checkTime->dateTime());
        $this->shouldFindTodo($id, $initialTodo);
        $this->shouldSaveTodo($expectedTodo);

        $handler($command);
    }
}
