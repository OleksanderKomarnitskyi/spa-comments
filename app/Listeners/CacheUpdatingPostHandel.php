<?php

namespace App\Listeners;

use App\Events\UpdatePostEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        Cache::put('posts:' . $event->post->id, $event->post, 60*60*24);
        if (Cache::has('posts:index')) {
            $posts = Cache::get('posts:index');
            $newItem = $event->post;
            $updatedPosts = $posts->map(function ($item) use ($newItem) {
                // Перевірте, чи поточний пост має той самий ідентифікатор, що і $itemId
                if ($item->id === $newItem->id) {
                    // Оновіть властивості поста
                    $item->title = $newItem->title;
                    $item->content = $newItem->content;
                }
                return $item;
            });
            Cache::put('posts:index', $updatedPosts, 60*60*24);
        }

    }
}
