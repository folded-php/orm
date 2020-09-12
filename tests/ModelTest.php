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

it("should paginate the model", function (): void {
    DatabaseConnections::add([
        "driver" => "sqlite",
        "database" => __DIR__ . "/misc/database.sqlite",
    ]);

    expect(Post::paginate()->toArray())->toBe([
        'current_page' => 1,
        'data' => [],
        'first_page_url' => '/?page=1',
        'from' => null,
        'last_page' => 1,
        'last_page_url' => '/?page=1',
        'next_page_url' => null,
        'path' => '/',
        'per_page' => 15,
        'prev_page_url' => null,
        'to' => null,
        'total' => 0,
    ]);
});

it("should go to the desired page", function (): void {
    DatabaseConnections::add([
        "driver" => "sqlite",
        "database" => __DIR__ . "/misc/database.sqlite",
    ]);

    $secondPost = [
        "id" => 2,
        "excerpt" => "Bar post.",
        "title" => "Bar",
    ];

    Post::insert(
        [
            "id" => 1,
            "title" => "Foo",
            "excerpt" => "Foo post.",
        ]
    );

    Post::insert($secondPost);

    expect(Post::toPage(2)->paginate(1)->items()[0]->toArray())->toBe($secondPost);
});
