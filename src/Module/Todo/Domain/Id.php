<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

use Ramsey\Uuid\Uuid;

final class Id
{
    private function __construct(private string $value)
    {
        $this->guard($value);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isEqualsTo(self $other): bool
    {
        return $this->value === $other->value();
    }

    private function guard(string $value): void
    {
        if (empty($value)) {
            throw InvalidId::empty();
        }

        if (!Uuid::isValid($value)) {
            throw InvalidId::invalidUuidFormat($value);
        }
    }
}
