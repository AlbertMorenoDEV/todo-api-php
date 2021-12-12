<?php

declare(strict_types = 1);

namespace App\Module\Todo\Infrastructure\Persistence;

use App\Module\Todo\Domain\Id;
use App\Module\Todo\Domain\Todo;
use App\Module\Todo\Domain\TodoNotFound;
use App\Module\Todo\Domain\TodoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;

final class MysqlTodoRepository implements TodoRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    /**
     * @throws ORMException
     */
    public function save(Todo $todo): void
    {
        $this->entityManager->persist($todo);
    }

    /**
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function find(Id $id): Todo
    {
        $todo = $this->entityManager->find(Todo::class, $id);

        if (null === $todo) {
            throw TodoNotFound::withId($id);
        }

        return $todo;
    }
}
