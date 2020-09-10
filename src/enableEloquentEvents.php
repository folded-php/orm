<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("enableEloquentEvents")) {
    function enableEloquentEvents(): void
    {
        Model::enableEvents();
    }
}
