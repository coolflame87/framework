<?php

declare(strict_types=1);

namespace FondBot\Tests\Unit\Conversation\Activators;

use FondBot\Tests\TestCase;
use FondBot\Events\MessageReceived;
use FondBot\Conversation\Activators\Contains;

class ContainsTest extends TestCase
{
    public function testMatches(): void
    {
        $message = new MessageReceived('this is foo');

        $activator = new Contains('foo');

        $this->assertTrue($activator->matches($message));
    }

    public function testDoesNotMatch(): void
    {
        $message = new MessageReceived('this is bar');

        $activator = new Contains('foo');

        $this->assertFalse($activator->matches($message));
    }

    public function testMessageDoesNotHaveText(): void
    {
        $message = new MessageReceived('');

        $activator = new Contains('foo');

        $this->assertFalse($activator->matches($message));
    }
}
