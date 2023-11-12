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
use App\Services\PostService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $cacheIndex = 'posts:page:1';
        $request->whenFilled('page', function (string $value) use (&$cacheIndex) {
            $cacheIndex = 'posts:page:'.$value;
        });

        $posts = Cache::remember($cacheIndex, 60*60, function ()  {
            return Post::select(['id', 'title', 'content', 'created_at'])
                ->orderByDesc('created_at')
                ->paginate(25)
                ->withQueryString();
        });

        $posts = PostResource::collection($posts);

        return inertia('Post/Index', compact('posts'));
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
        $post = Cache::remember('posts:' . $id, 60*60*24, function () use($id) {
            return Post::find($id);
        });

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
