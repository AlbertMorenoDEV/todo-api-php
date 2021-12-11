<?php

declare(strict_types = 1);

namespace App\Module\Todo\UI;

use App\Module\Todo\Application\Create\CreateTodoCommand;
use JsonException;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class PostTodoController
{
    private const JSON_SCHEMA = __DIR__ . '/schema/post_todo.schema.json';

    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @throws JsonException
     */
    #[Route('/todos', name: 'create_todo', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $errorResponse = $this->validateRequest($request);
        if (null !== $errorResponse) {
            return $errorResponse;
        }

        $requestBody = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->commandBus->dispatch(
            new CreateTodoCommand(
                $requestBody['data']['id'] ?? null,
                $requestBody['data']['attributes']['title'] ?? null,
                $requestBody['data']['attributes']['due_time'] ?? null,
            )
        );

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    private function validateRequest(Request $request): ?JsonResponse
    {
        $requestBodyToValidate = json_decode($request->getContent());
        $jsonValidator         = new Validator();
        $jsonValidator->validate($requestBodyToValidate, ['$ref' => 'file://' . self::JSON_SCHEMA]);
        if ($jsonValidator->isValid()) {
            return null;
        }

        $errors = [];
        foreach ($jsonValidator->getErrors() as $error) {
            $errors[] = ['title' => $error['message'], 'status' => Response::HTTP_BAD_REQUEST, 'meta' => $error];
        }

        return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
    }
}
