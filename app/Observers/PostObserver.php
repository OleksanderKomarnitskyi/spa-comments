<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        Cache::put('posts:' . $post->id, $post, 60*60*24);
        if (Cache::has('posts:index')) {
            $posts = Cache::get('posts:index');
            $posts->push($post);
            Cache::put('posts:index', $posts, 60*60*24);
        }

    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        Cache::forget('posts:' . $post->id);
        if (Cache::has('posts:index')) {
            $posts = Cache::get('posts:index');
            $updatedPosts = $posts->reject(function ($item) use ($post) {
                return $item->id === $post->id;
            });
            Cache::put('posts:index', $updatedPosts, 60*60*24);
        }

    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
