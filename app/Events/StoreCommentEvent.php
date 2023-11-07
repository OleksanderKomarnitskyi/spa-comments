<?php

namespace App\Events;

use App\Http\Resources\Comment\ShowChildrenCommentsResource;
use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreCommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var Model
     */
    private Model $comment;

    /**
     * Create a new event instance.
     */
    public function __construct(Model $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('store_comment_'. $this->comment->post_id),
        ];
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'store_comment';
    }

    /**
     * @return Comment[]
     */
    public function broadcastWith(): array
    {
        return ['comment' => ShowChildrenCommentsResource::make($this->comment)->resolve() ];
    }
}
