<?php

declare(strict_types = 1);

namespace Folded;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Represents a class that reflects a table in the database.
 *
 * @since 0.1.0
 */
class Model extends EloquentModel
{
    /**
     * Wether the Eloquent bootstrap has been started or not.
     *
     * @since 0.1.0
     */
    private static bool $engineBooted = false;

    /**
     * Wether the Eloquent event system is started or not.
     *
     * @since 0.1.0
     * @see https://laravel.com/docs/7.x/eloquent#events For more information about the Eloquent event system.
     */
    private static bool $eventsEnabled = false;

    /**
     * Constructor.
     *
     * @param array $attributes Fields and values to start with.
     *
     * @since 0.1.0
     *
     * @example
     * $post = new Post([
     *  "title" => "Something",
     *  "excerpt" => "My first post...",
     * ]);
     */
    public function __construct(array $attributes = [])
    {
        static::startEngine();

        parent::__construct($attributes);
    }

    /**
     * Reset the state of the object.
     * Useful for unit testing.
     *
     * @since 0.1.0
     *
     * @example
     * Model::clear();
     */
    public static function clear(): void
    {
        self::$engineBooted = false;
        self::$eventsEnabled = false;
    }

    /**
     * Disables the Eloquent event system for all the models.
     *
     * @since 0.1.0
     * @see https://laravel.com/docs/7.x/eloquent#events For more information about the Eloquent event system.
     *
     * @example
     * Model::disableEvents();
     */
    public static function disableEvents(): void
    {
        self::$eventsEnabled = false;
    }

    /**
     * Enables the Eloquent event system for all the models.
     *
     * @deprecated v0.1.1 Use Model::disableEvents() instead.
     * @since 0.1.0
     * @see https://laravel.com/docs/7.x/eloquent#events For more information about the Eloquent event system.
     *
     * @example
     * Model::enableEvent()
     */
    public static function enableEvent(): void
    {
        self::$eventsEnabled = true;
    }

    /**
     * Enables the Eloquent event system for all the models.
     *
     * @since 0.1.1
     * @see https://laravel.com/docs/7.x/eloquent#events For more information about the Eloquent event system.
     *
     * @example
     * Model::enableEvents()
     */
    public static function enableEvents(): void
    {
        self::$eventsEnabled = true;
    }

    /**
     * Starts the Eloquent engine.
     *
     * @since 0.1.0
     * @see https://laravel.com/docs/7.x/eloquent For more information about the Eloquent ORM.
     *
     * @example
     * Model::startEngine();
     */
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
