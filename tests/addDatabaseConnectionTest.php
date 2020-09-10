<?php

declare(strict_types = 1);

use Folded\DatabaseConnections;
use function Folded\addDatabaseConnection;

beforeEach(function (): void {
    DatabaseConnections::clear();
});

it("should add an sqlite database", function (): void {
    $connection = [
        "driver" => "sqlite",
        "database" => __DIR__ . "/misc/database.sqlite",
    ];

    addDatabaseConnection($connection);

    $connections= DatabaseConnections::getAll();

    expect($connections[0])->toBe($connection);
});
