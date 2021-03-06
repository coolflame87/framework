<?php

declare(strict_types=1);

namespace FondBot\Foundation;

use FondBot\Channels\Channel;
use FondBot\Conversation\Context;
use FondBot\Conversation\Session;
use FondBot\Conversation\ContextManager;
use FondBot\Conversation\SessionManager;
use Illuminate\Contracts\Bus\Dispatcher;
use FondBot\Foundation\Commands\SaveContext;
use FondBot\Foundation\Commands\SaveSession;
use Illuminate\Contracts\Container\Container;

class Kernel
{
    public const VERSION = '2.0';

    private $container;
    private $bus;

    /** @var Channel */
    private $channel;

    /** @var Session|null */
    private $session;

    /** @var Context|null */
    private $context;

    public function __construct(Container $container, Dispatcher $bus)
    {
        $this->container = $container;
        $this->bus = $bus;
    }

    /**
     * Initialize kernel.
     *
     * @param Channel $channel
     */
    public function initialize(Channel $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * Perform shutdown tasks.
     */
    public function terminate(): void
    {
        // Save session if exists
        if ($this->session !== null) {
            $this->bus->dispatch(new SaveSession($this->session));
        }

        // Save context if exists
        if ($this->context !== null) {
            $this->bus->dispatch(new SaveContext($this->context));
        }
    }

    /**
     * Get current channel.
     *
     * @return Channel|null
     */
    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    /**
     * Get session.
     *
     * @return Session|null
     */
    public function getSession(): ?Session
    {
        return $this->session;
    }

    /**
     * Set session.
     *
     * @param Session $session
     */
    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    /**
     * Close session.
     */
    public function closeSession(): void
    {
        if ($this->session !== null) {
            $this->sessionManager()->close($this->session);
            $this->session = null;
        }
    }

    /**
     * Get context.
     *
     * @return Context|null
     */
    public function getContext(): ?Context
    {
        return $this->context;
    }

    /**
     * Set context.
     *
     * @param Context $context
     */
    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    /**
     * Clear context.
     */
    public function clearContext(): void
    {
        if ($this->context !== null) {
            $this->contextManager()->clear($this->context);
            $this->context = null;
        }
    }

    /**
     * Get session manager.
     *
     * @return SessionManager
     */
    private function sessionManager(): SessionManager
    {
        return $this->container->make(SessionManager::class);
    }

    /**
     * Get context manager.
     *
     * @return ContextManager
     */
    private function contextManager(): ContextManager
    {
        return $this->container->make(ContextManager::class);
    }
}
