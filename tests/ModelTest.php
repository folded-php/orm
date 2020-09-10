<?php

declare(strict_types = 1);

use Folded\DatabaseConnections;
use Folded\Model;
use Test\Post;

beforeEach(function (): void {
    Model::clear();
    Post::getQuery()->delete();
});

it("should return all the posts", function (): void {
    DatabaseConnections::add([
        "driver" => "sqlite",
        "database" => __DIR__ . "/misc/database.sqlite",
    ]);

    Post::insert(
        [
            "title" => "Laravel Queues in Action",
            "excerpt" => "This eBook is a collection of real-world challenges with solutions that actually run in production.",
        ]
    );

    expect(Post::all()->toArray())->toBe([
        [
            "id" => 1,
            "excerpt" => "This eBook is a collection of real-world challenges with solutions that actually run in production.",
            "title" => "Laravel Queues in Action",
        ],
    ]);
});
