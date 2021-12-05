<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

final class Title
{
    private const MAX_CHARACTERS = 50;

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
            throw InvalidTitle::empty();
        }

        if (strlen($value) > self::MAX_CHARACTERS) {
            throw InvalidTitle::tooLong();
        }
    }
}
