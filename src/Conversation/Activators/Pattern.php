<?php

declare(strict_types=1);

namespace FondBot\Conversation\Activators;

use Spatie\Regex\Regex;
use FondBot\Events\MessageReceived;

class Pattern implements Activator
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Result of matching activator.
     *
     * @param MessageReceived $message
     *
     * @return bool
     */
    public function matches(MessageReceived $message): bool
    {
        $text = $message->getText();

        return Regex::match($this->value, $text)->hasMatch();
    }
}
