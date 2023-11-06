<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id ?? null,
            'subCount' => $this->subCommentCount(),
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'body' => $this->body,
            'url' => $this->url ?? "",
            'date' => $this->created_at->diffForHumans()
        ];
    }
}
