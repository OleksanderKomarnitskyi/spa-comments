<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Post;
use App\Services\PostService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class PostController extends Controller
{

    /**
     * @var PostService
     */
    private PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $posts = Post::select(['id', 'title', 'content','created_at'])
            ->orderByDesc('created_at')
            ->get();
        $posts = PostResource::collection($posts)->resolve();

        return inertia('Post/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return inertia('Post/Create');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse|string
     * @throws Exception
     */
    public function store(StoreRequest $request): RedirectResponse|string
    {
        $data = $request->validated();
        $post = $this->postService->create($data);

        if ($post) {
            return redirect()->route('post.index');
        } else {
            return response("Error", 500);
        }
    }

    /**
     * @param Post $post
     * @param UpdateRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(Post $post, UpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->postService->update($post,$data);
        return redirect()->route('post.index');
    }

    /**
     * @param $post
     * @return Response
     */
    public function show($post): Response
    {
        $post = Post::with([
            'comments',
        ])->withCount('comments')
            ->whereId($post)
            ->first();

       $post = ShowPostResource::make($post)->resolve();
       return inertia('Post/Show', compact('post'));
    }

    /**
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post): Response
    {
        return inertia('Post/Edit', compact('post'));
    }

    /**
     * @param Post $post
     * @return RedirectResponse
     */
    public function delete(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route('post.index');

    }

}
