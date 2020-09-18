# folded/orm

A standalone Eloquent ORM for you web app.

[![Packagist License](https://img.shields.io/packagist/l/folded/orm)](https://github.com/folded-php/orm/blob/master/LICENSE) [![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/folded/orm)](https://github.com/folded-php/orm/blob/master/composer.json#L14) [![Packagist Version](https://img.shields.io/packagist/v/folded/orm)](https://packagist.org/packages/folded/orm) [![Build Status](https://travis-ci.com/folded-php/orm.svg?branch=master)](https://travis-ci.com/folded-php/orm) [![Maintainability](https://api.codeclimate.com/v1/badges/9e72165b7dbf2a78b7db/maintainability)](https://codeclimate.com/github/folded-php/orm/maintainability) [![TODOs](https://img.shields.io/endpoint?url=https://api.tickgit.com/badge?repo=github.com/folded-php/orm)](https://www.tickgit.com/browse?repo=github.com/folded-php/orm)

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

Folded is a constellation of packages to help you setting up a web app easily, using ready to plug in packages.

- [folded/action](https://github.com/folded-php/action): A way to organize your controllers for your web app.
- [folded/config](https://github.com/folded-php/config): Configuration utilities for your PHP web app.
- [folded/crypt](https://github.com/folded-php/crypt): Encrypt and decrypt strings for your web app.
- [folded/exception](https://github.com/folded-php/exception): Various kind of exception to throw for your web app.
- [folded/history](https://github.com/folded-php/history): Manipulate the browser history for your web app.
- [folded/request](https://github.com/folded-php/request): Request utilities, including a request validator, for your PHP web app.
- [folded/routing](https://github.com/folded-php/routing): Routing functions for your PHP web app.
- [folded/session](https://github.com/folded-php/session): Session functions for your web app.
- [folded/view](https://github.com/folded-php/view): View utilities for your PHP web app.

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
composer require folded/orm
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
- [4. Go to a specific page before paginating](#4-go-to-a-specific-page-before-paginating)

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

### 4. Go to a specific page before paginating

In this example, we will instruct the paginator to go to a certain page before paginating. As we are not in Laravel, this is required to correctly returns the items according to the browsed page.

```php
$posts = Post::toPage(2)->paginate(15);
```

The page number should come for example from the query strings, like when the user browse `/post?page=2`.

However, for technical reasons, I could not find how to provide the same method after you call eloquent methods before. Which means that the following code will not work:

```php
$posts = Post::where("author", "foo")->toPage(2)->paginate(15);
```

To fix this issue, use the verbose version of `->paginate()`:

```php
$posts = Post::where("author", "foo")->paginate(15, ["*"], "page", 2); // 2 is the page number
```

## Version support

|        | 7.3 | 7.4 | 8.0 |
| ------ | --- | --- | --- |
| v0.1.0 | ❌  | ✔️  | ❓  |
| v0.1.1 | ❌  | ✔️  | ❓  |
| v0.2.0 | ❌  | ✔️  | ❓  |

## Credits

This library would not have see the light without the impressive work from Matt Stauffer with [Torch](https://github.com/mattstauffer/Torch).

Torch is a project to provide instructions and examples for using Illuminate components as standalone components in non-Laravel applications, including Eloquent.

Give this man an ice cold beer, [a star](https://github.com/mattstauffer/Torch) to this great idea, and follow him on Twitter [@stauffermatt](https://twitter.com/stauffermatt)!
