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

    public function addFlash(string $type, string $message): void
    {
        if ($flashes = $this->sessionService->get('bcf_array')) {
            $flashes[] = new Flash($type, $message);

            $this->sessionService->set('bcf_array', $flashes);

            return;
        }

        $this->sessionService->set('bcf_array', [new Flash($type, $message)]);
    }

    /**
     * @return Flash[]
     */
    public function flashes(): array
    {
        $flashes = $this->sessionService->get('bcf_array') ?? [];

        $this->sessionService->unset('bcf_array');
        
        return $flashes;
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