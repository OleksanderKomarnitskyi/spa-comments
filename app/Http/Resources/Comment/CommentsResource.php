<?php

namespace App\Http\Resources\Comment;

use Carbon\Carbon;
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
            'subCount' => $this->replies_count ?? 0,
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'body' => $this->body,
            'url' => $this->url ?? "",
            'date' => Carbon::create($this->created_at)->format('m.d.y' . ' в ' . 'h:m' )
        ];
    }
}
