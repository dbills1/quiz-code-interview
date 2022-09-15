<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('reportError')) {
    function reportError(string $message): void
    {
        Log::error("$message");
    }
}
