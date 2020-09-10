<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("disableEloquentEvents")) {
    function disableEloquentEvents(): void
    {
        Model::disableEvents();
    }
}
