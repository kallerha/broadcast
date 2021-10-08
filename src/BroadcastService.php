<?php

declare(strict_types=1);

namespace FluencePrototype\Broadcast;

use FluencePrototype\Session\SessionService;
use JetBrains\PhpStorm\Pure;

/**
 * Class BroadcastService
 * @package FluencePrototype\Broadcast
 */
class BroadcastService
{

    private SessionService $sessionService;

    /**
     * BroadcastService constructor.
     */
    #[Pure] public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    /**
     * @param string $name
     * @param string|int $message
     * @return bool
     */
    public function transmit(string $name, string|int $message): bool
    {
        if (!$this->sessionService->isSet('bc_' . $name)) {
            $this->sessionService->set('bc_' . $name, $message);

            return true;
        }

        return false;
    }

    /**
     * @param string $name
     * @return string|int|null
     */
    public function dispatch(string $name): string|int|null
    {
        $message = $this->sessionService->get('bc_' . $name);
        $this->sessionService->unset('bc_' . $name);

        return $message;
    }

}