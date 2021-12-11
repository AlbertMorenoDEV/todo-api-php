<?php

declare(strict_types = 1);

namespace App\Module\Todo\Infrastructure\Persistence;

use App\Module\Todo\Domain\Todo;
use App\Module\Todo\Domain\TodoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

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
}
