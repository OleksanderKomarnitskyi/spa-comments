<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $posts = PostResource::collection($posts)->resolve();

        return inertia('Post/Index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return inertia('Post/Create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $post = Post::create($data);
        return redirect()->route('post.index');
    }

    public function update(Post $post, UpdateRequest $request)
    {
        Post::updated($request->validated());
        return redirect()->route('post.index');
    }

    public function show($post)
    {
        $post = Post::with([
            'comments',
        ])->withCount('comments')
            ->whereId($post)
            ->first();

       $post = ShowPostResource::make($post)->resolve();
       return inertia('Post/Show', compact('post'));
    }

    public function edit(Post $post)
    {
        return inertia('Post/Edit', compact('post'));
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');

    }

}
