<?php

namespace App\Listeners;

use App\Events\UpdatePostEvent;
use Illuminate\Support\Facades\Cache;

class CacheUpdatingPostHandel
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdatePostEvent  $event): void
    {
        Cache::flush();
    }
}
