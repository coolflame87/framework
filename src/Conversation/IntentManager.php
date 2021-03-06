<?php

declare(strict_types=1);

namespace FondBot\Conversation;

use FondBot\Events\MessageReceived;

class IntentManager
{
    /** @var Intent[] */
    private $intents = [];

    /** @var Intent */
    private $fallbackIntent;

    /**
     * Register intents.
     *
     * @param array  $intents
     * @param string $fallbackIntent
     */
    public function register(array $intents, string $fallbackIntent): void
    {
    }

    /**
     * Find intent.
     *
     * @param MessageReceived $message
     *
     * @return Intent|null
     */
    public function find(MessageReceived $message): ?Intent
    {
        foreach ($this->intents as $intent) {
            foreach ($intent->activators() as $activator) {
                if ($activator->matches($message) && $intent->passesAuthorization($message)) {
                    return $intent;
                }
            }
        }

        // Otherwise, return fallback intent
        return $this->fallbackIntent;
    }

    /**
     * Add intent.
     *
     * @param Intent $intent
     */
    public function add(Intent $intent): void
    {
        if (!in_array($intent, $this->intents, true)) {
            $this->intents[] = $intent;
        }
    }

    /**
     * Set fallback intent.
     *
     * @param Intent $intent
     */
    public function setFallbackIntent(Intent $intent): void
    {
        $this->fallbackIntent = $intent;
    }
}
