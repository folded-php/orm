<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("addDatabaseConnection")) {
    function addDatabaseConnection(array $connection): void
    {
        DatabaseConnections::add($connection);
    }
}
