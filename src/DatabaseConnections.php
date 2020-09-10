<?php

declare(strict_types = 1);

namespace Folded;

use InvalidArgumentException;

class DatabaseConnections
{
    const DRIVER_MSSQL = "mssql";

    const DRIVER_MYSQL = "mysql";

    const DRIVER_PGSQL = "pgsql";

    const DRIVER_SQLITE = "sqlite";

    const SUPPORTED_DRIVERS = [self::DRIVER_MYSQL, self::DRIVER_PGSQL, self::DRIVER_MSSQL, self::DRIVER_SQLITE];

    private static array $connections = [];

    private static array $currentConnection = [];

    public static function add(array $connection): void
    {
        static::$currentConnection = $connection;

        self::checkCurrentConnection();

        self::$connections[] = $connection;
    }

    public static function clear(): void
    {
        self::$connections = [];
        self::$currentConnection = [];
    }

    public static function getAll(): array
    {
        return self::$connections;
    }

    private static function checkCharset(): void
    {
        if (self::currentConnectionKeyPresent("charset") && !self::currentConnectionKeyIsString("charset")) {
            throw new InvalidArgumentException("charset must be a string in the database connection");
        }
    }

    private static function checkCollation(): void
    {
        if (self::currentConnectionKeyPresent("collation") && !self::currentConnectionKeyIsString("collation")) {
            throw new InvalidArgumentException("collation must be a string in the database connection");
        }
    }

    private static function checkCurrentConnection(): void
    {
        self::checkDriver();
        self::checkDatabase();

        if (self::currentDriverIsSqlite()) {
            return;
        }

        self::checkHost();
        self::checkUsername();
        self::checkPassword();
        self::checkCharset();
        self::checkCollation();
        self::checkPrefix();
    }

    private static function checkDatabase(): void
    {
        if (!self::currentConnectionKeyPresent("database")) {
            throw new InvalidArgumentException("database is missing from the database connection");
        }

        if (!self::currentConnectionKeyIsString("database")) {
            throw new InvalidArgumentException("database must be a string in the database connection");
        }

        if (!self::currentConnectionKeyFilled("database")) {
            throw new InvalidArgumentException("database is empty in the database connection");
        }
    }

    private static function checkDriver(): void
    {
        if (!self::currentConnectionKeyPresent("driver")) {
            throw new InvalidArgumentException("driver is missing from the database connection");
        }

        if (!self::currentConnectionKeyIsString("driver")) {
            throw new InvalidArgumentException("driver must be a string in the database connection");
        }

        if (!self::currentConnectionKeyFilled("driver")) {
            throw new InvalidArgumentException("driver is empty in the database connection");
        }

        if (!self::driverSupported()) {
            $driver = self::getCurrentConnectionDriver();

            $supportedDrivers = join(", ", self::SUPPORTED_DRIVERS);

            throw new InvalidArgumentException("driver $driver not supported (supported: $supportedDrivers)");
        }
    }

    private static function checkHost(): void
    {
        if (!self::currentConnectionKeyPresent("host")) {
            throw new InvalidArgumentException("host is missing from the database connection");
        }

        if (!self::currentConnectionKeyIsString("host")) {
            throw new InvalidArgumentException("host must be a string in the database connection");
        }

        if (!self::currentConnectionKeyFilled("host")) {
            throw new InvalidArgumentException("host is empty in the database connection");
        }
    }

    private static function checkPassword(): void
    {
        if (self::currentConnectionKeyPresent("password") && !self::currentConnectionKeyIsString("password")) {
            throw new InvalidArgumentException("password must be a string in the database connection");
        }
    }

    private static function checkPrefix(): void
    {
        if (self::currentConnectionKeyPresent("prefix") && !self::currentConnectionKeyIsString("prefix")) {
            throw new InvalidArgumentException("prefix must be a string in the database connection");
        }
    }

    private static function checkUsername(): void
    {
        if (!self::currentConnectionKeyPresent("username")) {
            throw new InvalidArgumentException("username is missing from the database connection");
        }

        if (!self::currentConnectionKeyIsString("username")) {
            throw new InvalidArgumentException("username must be a string in the database connection");
        }

        if (!self::currentConnectionKeyFilled("username")) {
            throw new InvalidArgumentException("username is empty in the database connection");
        }
    }

    private static function currentConnectionKeyFilled(string $key): bool
    {
        return !empty(trim(self::$currentConnection[$key]));
    }

    private static function currentConnectionKeyIsString(string $key): bool
    {
        return is_string(self::$currentConnection[$key]);
    }

    private static function currentConnectionKeyPresent(string $key): bool
    {
        return isset(self::$currentConnection[$key]);
    }

    private static function currentDriverIsSqlite(): bool
    {
        return isset(self::$currentConnection["driver"]) && self::$currentConnection["driver"] === self::DRIVER_SQLITE;
    }

    private static function driverSupported(): bool
    {
        return in_array(self::$currentConnection["driver"], self::SUPPORTED_DRIVERS, true);
    }

    private static function getCurrentConnectionDriver(): string
    {
        return self::$currentConnection["driver"] ?? "";
    }
}
