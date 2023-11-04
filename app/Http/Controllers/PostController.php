<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        dd($posts);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        dd('cratepe page');
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'body'=>'required',
        ]);
        $post = Post::create($request->all());
        dd($post);
        return redirect()->route('posts.index');
    }

    public function show($id)
    {
        $post = Post::find($id);
        dd($post);
        return view('posts.show', compact('post'));
    }

}
