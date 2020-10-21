<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Components\{File\FileHandler,
    File\LocalFileHandler,
    Hash\HashHandler,
    Hash\IHash,
    Local\LocalCache,
    Local\APCuLocalCache,
    Queue\QueueClient,
    Queue\RedisQueueClient
};

/**
 * Class ComponentServiceProvider
 * @package App\Providers
 */
class ComponentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LocalCache::class, APCuLocalCache::class);
        $this->app->singleton(QueueClient::class, RedisQueueClient::class);
        $this->app->singleton(FileHandler::class, LocalFileHandler::class);
        $this->app->singleton(IHash::class, HashHandler::class);
    }
}
