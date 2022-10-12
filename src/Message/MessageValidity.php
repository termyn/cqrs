<?php

declare(strict_types=1);

namespace Codea\Cqrs\Message;

final class MessageValidity
{
    public readonly array $errors;

    public function __construct(
        public readonly string $name,
        string ...$errors
    ) {
        $this->errors = $errors;
    }

    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }
}
