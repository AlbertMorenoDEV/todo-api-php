<?php

declare(strict_types = 1);

namespace App\Module\Todo\UI;

use App\Module\Todo\Application\Create\CreateTodoCommand;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class PostTodoController
{
//    private const JSON_SCHEMA = 'create_todo.schema.json';

    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @throws JsonException
     */
    #[Route('/todos', name: 'create_todo', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $requestBody = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        // validate with JSON:SCHEMA

        $this->commandBus->dispatch(
            new CreateTodoCommand(
                $requestBody['data']['id'] ?? null,
                $requestBody['data']['attributes']['title'] ?? null,
                $requestBody['data']['attributes']['due_time'] ?? null,
            )
        );

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
