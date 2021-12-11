<?php

declare(strict_types = 1);

namespace App\Module\Todo\Infrastructure\Persistence\Doctrine;

use App\Module\Todo\Domain\DueTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class DueTimeType extends StringType
{
    public const NAME = 'due_time';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DueTime
    {
        return $value !== null ? DueTime::fromInteger($value) : null;
    }

    /**
     * @param ?DueTime $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value?->value();
    }
}
