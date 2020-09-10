<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("addDatabaseConnection")) {
    /**
     * Add a new database connection.
     *
     * @since 0.1.0
     *
     * @example
     * addDatabaseConnection([
     *  "driver" => "mysql",
     *  "host" => "localhost",
     *  "username" => "root",
     *  "password" => "root",
     * ]);
     */
    function addDatabaseConnection(array $connection): void
    {
        DatabaseConnections::add($connection);
    }
}
