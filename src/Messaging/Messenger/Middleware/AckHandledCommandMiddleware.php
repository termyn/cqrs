<?php

declare(strict_types=1);

namespace Termyn\Cqrs\Messaging\Messenger\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface as Middleware;
use Symfony\Component\Messenger\Middleware\StackInterface as Stack;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Termyn\Cqrs\Command;
use Termyn\Cqrs\Messaging\Messenger\Stamp\CommandResultStamp;
use Termyn\DateTime\Clock;

final readonly class AckHandledCommandMiddleware implements Middleware
{
    use MetadataTrait;
    use StackTrait;

    public function __construct(
        private Clock $clock,
    ) {
    }

    public function handle(Envelope $envelope, Stack $stack): Envelope
    {
        $envelope = $this->next($envelope, $stack);

        $metadata = $this->getMetadata($envelope);

        $message = $envelope->getMessage();
        if ($message instanceof Command) {
            $envelope = $envelope->last(HandledStamp::class)
                ? $envelope->with(
                    CommandResultStamp::handled(
                        id: $metadata->messageId,
                        createdAt: $this->clock->measure()
                    )
                ) : $envelope;
        }

        return $envelope;
    }
}
