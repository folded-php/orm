# folded/orm

A standalone Eloquent ORM for you web app.

## Summary

- [About](#about)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Examples](#examples)
- [Version support](#version-support)
- [Credits](#credits)

## About

Provides a standalone package to use Eloquent model inside your web app, with minimal configuration.

## Features

- All the features provided by Laravel's Eloquent
- Eager load the engine, so if a request does not call an eloquent method, it is never booted
- Enable the Eloquent events only if you need them

## Requirements

- PHP version >= 7.4.0
- Composer installed
- Knowledge with [Eloquent ORM](https://laravel.com/docs/7.x/eloquent)

## Installation

- [1. Install the package](#1-instal-the-package)
- [2. Add a database connection](#2-add-a-database-connection)
- [3. Create your model class](#3-create-your-model-file)

### 1. Install the package

In your root directory, run this command:

```bash
composer required folded/orm
```

### 2. Add a database connection

Call this method before using your Eloquent model to provide with your database connection information:

```php
use function Folded\addDatabaseConnection;

addDatabaseConnection([
  "driver" => "mysql",
  "host" => "localhost",
  "username" => "root",
  "password" => "root",
]);
```

You can see a complete list of options in the example [put example here].

### 3. Create your model file

Anywhere you want, create a class to map your table.

```php
namespace App;

use Folded\Model;

class Post extends Model
{
  //
}
```

## Examples

As this library relies on Eloquent, you will find a useful amount of information about all the capability of this ORM in [the official documentation](https://laravel.com/docs/7.x/eloquent).

- [1. Get all the data from your model](#1-get-all-the-data-from-your-model)
- [2. Add more information to the database connection](#2-add-more-information-to-the-database-connection)
- [3. Enable/disable eloquent events](#3-enable-disable-eloquent-events)

### 1. Get all the data from your model

In this example, we will use our `Post` class to get all the posts.

```php
use App\Post;

$posts = Post::all();

foreach ($posts as $post) {
  echo "{$post->title}: {$post->excerpt}";
}
```

### 2. Add more information to the database connection

In this example, we will see a complete list of keys you can set on the database connection.

```php
use function Folded\addDatabaseConnection;

addDatabaseConnection([
  "driver" => "mysql",
  "host" => "localhost",
  "database" => "my-blog",
  "username" => "root",
  "password" => "root",
  "charset" => "utf8mb4",
  "collation" => "utf8mb4_general_ci",
  "prefix" => "wp_",
]);
```

### 3. Enable/disable eloquent events

In this example, we will enable, then disable the Eloquent events system. Learn more on [the official documentation](https://laravel.com/docs/7.x/eloquent#events).

```php
use function Folded\enableEloquentEvents;
use function Folded\disableEloquentEvents;

enableEloquentEvents();
disableEloquentEvents();
```

## Version support

|        | 7.3 | 7.4 | 8.0 |
| ------ | --- | --- | --- |
| v0.1.0 | ❌  | ✔️  | ❓  |

## Credits

This library would not have see the light without the impressive work from Matt Stauffer with [Torch](https://github.com/mattstauffer/Torch).

Torch is a project to provide instructions and examples for using Illuminate components as standalone components in non-Laravel applications, including Eloquent.

Give this man an ice cold beer, [a star](https://github.com/mattstauffer/Torch) to this great idea, and follow him on Twitter [@stauffermatt](https://twitter.com/stauffermatt)!
