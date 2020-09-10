<?php

declare(strict_types = 1);

namespace Folded;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    private static bool $engineBooted = false;

    private static bool $eventsEnabled = false;

    public function __construct(array $attributes = [])
    {
        static::startEngine();

        parent::__construct($attributes);
    }

    public static function clear(): void
    {
        self::$engineBooted = false;
        self::$eventsEnabled = false;
    }

    public static function disableEvents(): void
    {
        self::$eventsEnabled = false;
    }

    public static function enableEvent(): void
    {
        self::$eventsEnabled = true;
    }

    private static function startEngine(): void
    {
        if (static::$engineBooted) {
            return;
        }

        $connections = DatabaseConnections::getAll();

        $manager = new Manager();

        foreach ($connections as $index => $connection) {
            $connectionName = $index === 0 ? "default" : $connection["driver"];
            $manager->addConnection($connection, $connectionName);
        }

        if (self::$eventsEnabled) {
            // Set the event dispatcher used by Eloquent models... (optional)
            $manager->setEventDispatcher(new Dispatcher(new Container()));
        }

        // Make this Capsule instance available globally via static methods... (optional)
        $manager->setAsGlobal();
        $manager->bootEloquent();

        static::$engineBooted = true;
    }
}
