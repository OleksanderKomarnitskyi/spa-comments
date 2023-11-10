<?php

namespace App\Http\Controllers;

use App\Events\UpdatePostEvent;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Comment\CommentsResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Observers\PostObserver;
use App\Services\PostService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Response;
use Inertia\ResponseFactory;

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
        $posts = Cache::remember('posts:index', 60*60*24, function ()  {
            return Post::select(['id', 'title', 'content', 'created_at'])->get();
        });

        $posts = PostResource::collection($posts->sortByDesc('created_at'))->resolve();

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
        $this->postService->update($post, $data);
        event(new UpdatePostEvent($post));
        return redirect()->route('post.index');
    }


    public function show($id)
    {
        if (Cache::has('posts:' . $id)) {
            $post = Cache::get('posts:' . $id);
        } else {
            $post = Post::find($id);
        }

        if (!$post) {
            return response("Not found content", 404);
        }

        $comments = [];
        $post->loadCount('comments');
        $post = ShowPostResource::make($post)->resolve();

        if ($post['commentsCount']) {
            $comments = Comment::with('replies')
                ->withCount('replies')
                ->where('post_id', $post['id'])
                ->whereNull('parent_id')
                ->orderByDesc('created_at')
                ->paginate(25)
                ->withQueryString();
            $comments = CommentsResource::collection($comments);
        }
        return inertia('Post/Show', compact('post', 'comments'));
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
