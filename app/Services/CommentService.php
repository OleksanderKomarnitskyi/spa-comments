<?php

namespace App\Services;

use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class CommentService extends MySqlService
{
    /**
     * @param Post $post
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function create(Post $post, array $data): Model
    {
        DB::beginTransaction();
        try {

           $comment = $post->comments()->create($data);

            if (isset($data['parent_id']) && $data['parent_id'] != null) {
                $comment->parent()->associate($data['parent_id']);
            }
            $comment->save();

            DB::commit();

            return $comment;
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

}
