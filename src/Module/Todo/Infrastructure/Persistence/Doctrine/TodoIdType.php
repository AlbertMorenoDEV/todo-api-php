<?php

declare(strict_types = 1);

namespace App\Module\Todo\Infrastructure\Persistence\Doctrine;

use App\Module\Todo\Domain\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class TodoIdType extends StringType
{
    public const NAME = 'todo_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        return $value !== null ? Id::fromString($value) : null;
    }

    /**
     * @param ?Id $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value();
    }
}
