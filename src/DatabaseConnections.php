<?php

declare(strict_types = 1);

namespace Folded;

use InvalidArgumentException;

/**
 * Represents a database connection for the Model class to be used.
 *
 * @since 0.1.0
 */
final class DatabaseConnections
{
    /**
     * @since 0.1.0
     */
    const DRIVER_MSSQL = "mssql";

    /**
     * @since 0.1.0
     */
    const DRIVER_MYSQL = "mysql";

    /**
     * @since 0.1.0
     */
    const DRIVER_PGSQL = "pgsql";

    /**
     * @since 0.1.0
     */
    const DRIVER_SQLITE = "sqlite";

    /**
     * @since 0.1.0
     */
    const SUPPORTED_DRIVERS = [self::DRIVER_MYSQL, self::DRIVER_PGSQL, self::DRIVER_MSSQL, self::DRIVER_SQLITE];

    /**
     * Stores the database connections.
     *
     * @var array<array<mixed>>
     *
     * @since 0.1.0
     */
    private static array $connections = [];

    /**
     * Stores the current connection being checked and added to the list of connections.
     *
     * @var array<mixed>
     *
     * @since 0.1.0
     */
    private static array $currentConnection = [];

    /**
     * Add a new database connection.
     *
     * @param array<mixed> $connection The connection parameters.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::add([
     *  "driver" => "mysql",
     *  "host" => "localhost",
     *  "username" => "root",
     *  "password" => "root",
     * ]);
     */
    public static function add(array $connection): void
    {
        self::$currentConnection = $connection;

        self::checkCurrentConnection();

        self::$connections[] = $connection;
    }

    /**
     * Reset the state of this object.
     * Useful for unit testing.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::clear();
     */
    public static function clear(): void
    {
        self::$connections = [];
        self::$currentConnection = [];
    }

    /**
     * Get all the database connections.
     *
     * @return array<array<mixed>>
     *
     * @since 0.1.0
     *
     * @example
     * $connections = DatabaseConnections::getAll();
     */
    public static function getAll(): array
    {
        return self::$connections;
    }

    /**
     * Check if the charset in the current connection is valid.
     *
     * @throws InvalidArgumentException If the charset is not a string.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkCharset();
     */
    private static function checkCharset(): void
    {
        if (self::currentConnectionKeyPresent("charset") && !self::currentConnectionKeyIsString("charset")) {
            throw new InvalidArgumentException("charset must be a string in the database connection");
        }
    }

    /**
     * Checks if the collaction in the current database connection is valid.
     *
     * @throws InvalidArgumentException If the collation is not a string.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkCollation();
     */
    private static function checkCollation(): void
    {
        if (self::currentConnectionKeyPresent("collation") && !self::currentConnectionKeyIsString("collation")) {
            throw new InvalidArgumentException("collation must be a string in the database connection");
        }
    }

    /**
     * Checks if the current connection is valid.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkCurrentConnection();
     */
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

    /**
     * Check if the database in the current connection is valid.
     *
     * @throws InvalidArgumentException If the database key is mission.
     * @throws InvalidArgumentException If the database is not a string.
     * @throws InvalidArgumentException If the database is empty.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkDatabase();
     */
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

    /**
     * Checks if the driver is valid in the current connection.
     *
     * @throws InvalidArgumentException If the driver key is missing.
     * @throws InvalidArgumentException If the driver is not a string.
     * @throws InvalidArgumentException If the driver is empty.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkDriver();
     */
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

    /**
     * Check if the host in the current connection is valid.
     *
     * @throws InvalidArgumentException If the host key is missing.
     * @throws InvalidArgumentException If the host is not a string.
     * @throws InvalidArgumentException If the host is empty.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkHost();
     */
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

    /**
     * Checks if the password is valid in the current connection.
     *
     * @throws InvalidArgumentException If the password is not a string.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkPassword();
     */
    private static function checkPassword(): void
    {
        if (self::currentConnectionKeyPresent("password") && !self::currentConnectionKeyIsString("password")) {
            throw new InvalidArgumentException("password must be a string in the database connection");
        }
    }

    /**
     * Check the prefix in the current connection.
     *
     * @throws InvalidArgumentException if the prefix is not a string.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkPrefix();
     */
    private static function checkPrefix(): void
    {
        if (self::currentConnectionKeyPresent("prefix") && !self::currentConnectionKeyIsString("prefix")) {
            throw new InvalidArgumentException("prefix must be a string in the database connection");
        }
    }

    /**
     * Checks if the username is valid in the current database connection.
     *
     * @throws InvalidArgumentException If the username key is missing.
     * @throws InvalidArgumentException If the username is not a string.
     * @throws InvalidArgumentException If the username is empty.
     *
     * @since 0.1.0
     *
     * @example
     * DatabaseConnections::checkUsername();
     */
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

    /**
     * Returns true if the connection key is filled.
     *
     * @since 0.1.0
     *
     * @example
     * if (DatabaseConnections::currentConnectionKeyFilled("driver")) {
     *  echo "driver is filled";
     * } else {
     *  echo "driver is not filled";
     * }
     */
    private static function currentConnectionKeyFilled(string $key): bool
    {
        return !empty(trim(self::$currentConnection[$key]));
    }

    /**
     * Returns true if the current connection key is a string.
     *
     * @since 0.1.0
     *
     * @example
     * if (DatabaseConnections::currentConnectionKeyIsString("driver")) {
     *  echo "driver is a string";
     * } else {
     *  echo "driver is not a string";
     * }
     */
    private static function currentConnectionKeyIsString(string $key): bool
    {
        return is_string(self::$currentConnection[$key]);
    }

    /**
     * Returns true if the current connection key is specified.
     *
     * @since 0.1.0
     *
     * @example
     * if (DatabaseConnections::currentConnectionKeyPresent("driver")) {
     *  echo "driver key is present";
     * } else {
     *  echo "driver key not present";
     * }
     */
    private static function currentConnectionKeyPresent(string $key): bool
    {
        return isset(self::$currentConnection[$key]);
    }

    /**
     * Returns true if the current driver is SQLite.
     *
     * @since 0.1.0
     *
     * @example
     * if (DatabaseConnections::currentDriverIsSqlite()) {
     *  echo "current driver is SQLite";
     * } else {
     *  echo "current driver is not SQLite";
     * }
     */
    private static function currentDriverIsSqlite(): bool
    {
        return isset(self::$currentConnection["driver"]) && self::$currentConnection["driver"] === self::DRIVER_SQLITE;
    }

    /**
     * Returns true if the current driver is supported.
     *
     * @since 0.1.0
     *
     * @example
     * if (DatabaseConnections::driverSupported("mysql")) {
     *  echo "mysql driver is supported";
     * } else {
     *  echo "mysql driver is not supported";
     * }
     */
    private static function driverSupported(): bool
    {
        return in_array(self::$currentConnection["driver"], self::SUPPORTED_DRIVERS, true);
    }

    /**
     * Get the driver in the current connection.
     *
     * @since 0.1.0
     *
     * @example
     * $driver = DatabaseConnections::getCurrentConnectionDriver();
     */
    private static function getCurrentConnectionDriver(): string
    {
        return self::$currentConnection["driver"] ?? "";
    }
}
