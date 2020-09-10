<?php

declare(strict_types = 1);

use Folded\DatabaseConnections;

it("should add a connection", function (): void {
    $connection = [
        "driver" => "sqlite",
        "database" => __DIR__ . "/misc/database.sqlite",
    ];

    DatabaseConnections::add($connection);

    $firstConnection = DatabaseConnections::getAll()[0];

    expect($firstConnection)->toBe($connection);
});

it("should throw an exception if the charset is not valid", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "root",
        "charset" => 42,
    ]);
});

it("should throw an exception message if the charset is not valid", function (): void {
    $this->expectExceptionMessage("charset must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "root",
        "charset" => 42,
    ]);
});

it("should throw an exception if the collation is not valid", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "root",
        "collation" => 42,
    ]);
});

it("should throw an exception message if the collation is not valid", function (): void {
    $this->expectExceptionMessage("collation must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "root",
        "collation" => 42,
    ]);
});

it("should throw an exception if the database is not present", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
    ]);
});

it("should throw an exception message if the database is not present", function (): void {
    $this->expectExceptionMessage("database is missing from the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
    ]);
});

it("should throw an exception if the database is not a string", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => 42,
    ]);
});

it("should throw an exception message if the database is not a string", function (): void {
    $this->expectExceptionMessage("database must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => 42,
    ]);
});

it("should throw an exception if the database is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "",
    ]);
});

it("should throw an exception message if the database is empty", function (): void {
    $this->expectExceptionMessage("database is empty in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "",
    ]);
});

it("should throw an exception if the host is not present", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
    ]);
});

it("should throw an exception message if the host is not present", function (): void {
    $this->expectExceptionMessage("host is missing from the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
    ]);
});

it("should throw an exception if the host is not a string", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => 42,
    ]);
});

it("should throw an exception message if the host is not a string", function (): void {
    $this->expectExceptionMessage("host must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => 42,
    ]);
});

it("should throw an exception if the host is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "",
    ]);
});

it("should throw an exception message if the host is empty", function (): void {
    $this->expectExceptionMessage("host is empty in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "",
    ]);
});

it("should throw an exception if the username is not present", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
    ]);
});

it("should throw an exception message if the username is not present", function (): void {
    $this->expectExceptionMessage("username is missing from the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
    ]);
});

it("should throw an exception if the username is not a string", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => 42,
    ]);
});

it("should throw an exception message if the username is not a string", function (): void {
    $this->expectExceptionMessage("username must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => 42,
    ]);
});

it("should throw an exception if the username is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "",
    ]);
});

it("should throw an exception message if the username is empty", function (): void {
    $this->expectExceptionMessage("username is empty in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "",
    ]);
});

it("should throw an exception if the driver is not present", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([]);
});

it("should throw an exception message if the driver is not present", function (): void {
    $this->expectExceptionMessage("driver is missing from the database connection");

    DatabaseConnections::add([]);
});

it("should throw an exception if the driver is not a string", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" =>42,
    ]);
});

it("should throw an exception message if the driver is not a string", function (): void {
    $this->expectExceptionMessage("driver must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => 42,
    ]);
});

it("should throw an exception if the driver is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "",
    ]);
});

it("should throw an exception message if the driver is empty", function (): void {
    $this->expectExceptionMessage("driver is empty in the database connection");

    DatabaseConnections::add([
        "driver" => "",
    ]);
});

it("should throw an exception if the driver is not supported", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "foo",
    ]);
});

it("should throw an exception message if the driver is not supported", function (): void {
    $this->expectExceptionMessage("driver foo not supported (supported: mysql, pgsql, mssql, sqlite)");

    DatabaseConnections::add([
        "driver" => "foo",
    ]);
});

it("should throw an exception if the password is not a string", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "",
        "username" => "root",
        "password" => 42,
    ]);
});

it("should throw an exception message if the password is not a string", function (): void {
    $this->expectExceptionMessage("password must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "root",
        "password" => 42,
    ]);
});

it("should throw an exception if the collation is not a string", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "",
        "username" => "root",
        "collation" => 42,
    ]);
});

it("should throw an exception message if the collation is not a string", function (): void {
    $this->expectExceptionMessage("collation must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "root",
        "collation" => 42,
    ]);
});

it("should throw an exception if the prefix is not a string", function (): void {
    $this->expectException(InvalidArgumentException::class);

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "",
        "username" => "root",
        "prefix" => 42,
    ]);
});

it("should throw an exception message if the prefix is not a string", function (): void {
    $this->expectExceptionMessage("prefix must be a string in the database connection");

    DatabaseConnections::add([
        "driver" => "mysql",
        "database" => "test",
        "host" => "example.com",
        "username" => "root",
        "prefix" => 42,
    ]);
});
