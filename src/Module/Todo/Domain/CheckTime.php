<?php

declare(strict_types = 1);

namespace App\Module\Todo\Domain;

final class CheckTime
{
    private function __construct(private int $value)
    {
        $this->guard($value);
    }

    public static function fromInteger(int $value): self
    {
        return new self($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isEqualsTo(self $other): bool
    {
        return $this->value === $other->value();
    }

    private function guard(int $value): void
    {
        if (0 === $value) {
            throw InvalidCheckTime::invalid($value);
        }
    }
}
