<?php
declare(strict_types=1);

namespace FluencePrototype\Broadcast;

/**
 * Class BroadcastService
 * @package FluencePrototype\Flash
 */
class Flash
{

    public function __construct(
        private string $type,
        private string $message,
    )
    {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

}