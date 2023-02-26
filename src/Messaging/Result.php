<?php

declare(strict_types=1);

namespace Termyn\Cqrs\Messaging;

use Termyn\DateTime\Instant;
use Termyn\Id;

interface Result
{
    public function isSuccess(): bool;

    public function isFailure(): bool;

    public function hasPayload(): bool;

    public function hasErrors(): bool;

    public function id(): Id;

    public function errors(): iterable;

    public function payload(): iterable;

    public function payloadAsArray(): array;

    public function createdAt(): Instant;
}
