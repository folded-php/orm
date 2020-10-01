<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\enableEloquentEvents")) {
    /**
     * Enables the Eloquent event system for all the models.
     *
     * @since 0.1.0
     * @see https://laravel.com/docs/7.x/eloquent#events For more information about the Eloquent event system.
     *
     * @example
     * enableEloquentEvents()
     */
    function enableEloquentEvents(): void
    {
        Model::enableEvents();
    }
}
