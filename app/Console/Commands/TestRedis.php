<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TestRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis_Go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        Cache::put('example', "test1");
//        $str1 = Cache::get('example');
//        Cache::put('example', $str1 . " new ");
//        $str2 = Cache::get('example');
//        Cache::forget('example');
//        $str3 = Cache::get('example');

//        $str = "some string2";

//        if (Cache::has('example')) {
//            $result = Cache::get('example');
//        } else {
//            Cache::put('example', $str);
//            $result = Cache::get('example');
//        }

//        $result = Cache::remember('example', 60*60, function () use ($str) {
//           return $str;
//        });
//
//        $result = Cache::rememberForever('example2', function () use ($str) {
//            return $str . 2;
//        });

        $posts = Post::select(['id', 'title', 'content', 'created_at'])->get();

        foreach ($posts as $post) {
            Cache::put('posts:' . $post->id, $post, 60*60*24);
        }

    }
}
