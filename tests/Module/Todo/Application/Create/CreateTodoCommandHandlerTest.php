<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\Application\Create;

use App\Module\Todo\Application\Create\CreateTodoCommand;
use App\Module\Todo\Application\Create\CreateTodoCommandHandler;
use App\Module\Todo\Domain\InvalidId;
use App\Module\Todo\Domain\Todo;
use App\Tests\Infrastructure\Phpunit\ApplicationTestCase;
use App\Tests\Module\Todo\Domain\DueTimeStub;
use App\Tests\Module\Todo\Domain\IdStub;
use App\Tests\Module\Todo\Domain\TitleStub;
use App\Tests\Module\Todo\Infrastructure\TodoRepositoryMockTrait;

final class CreateTodoCommandHandlerTest extends ApplicationTestCase
{
    use TodoRepositoryMockTrait;

    /**
     * @test
     */
    public function itShouldSucceed(): void
    {
        $id           = IdStub::random();
        $title        = TitleStub::random();
        $dueTime      = DueTimeStub::future();
        $command      = new CreateTodoCommand($id->value(), $title->value(), $dueTime->value());
        $handler      = new CreateTodoCommandHandler($this->todoRepositoryMock());
        $expectedTodo = Todo::create($id, $title, $dueTime);

        $this->shouldSaveTodo($expectedTodo);

        $handler->handle($command);
    }
}
