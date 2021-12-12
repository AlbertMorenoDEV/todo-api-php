<?php

declare(strict_types = 1);

namespace App\Module\Todo\UI;

use App\Module\Todo\Application\Create\CreateTodoCommand;
use App\Module\Todo\Application\Update\MarkTodoAsDoneCommand;
use App\Module\Todo\Domain\TodoNotFound;
use JsonException;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class PatchTodoController
{
    private const JSON_SCHEMA = __DIR__ . '/schema/patch_todo.schema.json';

    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @throws JsonException
     */
    #[Route('/todos/{id}', name: 'modify_todo_field', methods: ['PATCH'])]
    public function __invoke(Request $request): Response
    {
        $errorResponse = $this->validateRequest($request);
        if (null !== $errorResponse) {
            return $errorResponse;
        }

        $requestBody = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        try {
            if (isset($requestBody['data']['attributes']['done']) && true === $requestBody['data']['attributes']['done']) {
                $this->commandBus->dispatch(new MarkTodoAsDoneCommand($requestBody['data']['id'] ?? null));
            }
        } catch (HandlerFailedException $e) {
            /** @var Throwable[] $exceptions */
            $exceptions = $e->getNestedExceptionOfClass(TodoNotFound::class);
            if (count($exceptions)) {
                $errors = [];

                foreach ($exceptions as $exception) {
                    $errors[] = ['title' => $exception->getMessage(), 'status' => Response::HTTP_BAD_REQUEST];
                }

                return new JsonResponse(['errors' => $errors], Response::HTTP_NOT_FOUND);
            }

            throw $e;
        }

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
