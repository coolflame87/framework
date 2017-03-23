<?php

declare(strict_types=1);

namespace FondBot\Channels;

use FondBot\Providers\ServiceProvider;

class ChannelServiceProvider extends ServiceProvider
{
    /**
     * Default drivers.
     *
     * @var array
     */
    private $drivers = [
        'Facebook' => Facebook\FacebookDriver::class,
        'Telegram'    => Telegram\TelegramDriver::class,
        'VK Communities' => VkCommunity\VkCommunityDriver::class,
    ];

    public function register()
    {
        $this->app->singleton(ChannelManager::class, function () {
            return new ChannelManager($this->drivers);
        });
    }
}
