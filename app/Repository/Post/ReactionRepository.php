<?php


namespace Repository\Post;


use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use Repository\Repository;

class ReactionRepository extends Repository
{

    public function model()
    {
        return Reaction::class;
    }

    public function findByPost($postId, $reactionId, $userId)
    {
       return $this->model()::where('reactable_type', Post::class)
            ->where('reactable_id', $postId)
            ->where('user_id', $userId)
            ->findOrFail($reactionId);
    }

    public function updateOrCreate($reactableId, $reactableType, $userId, $reactionType)
    {
       return $this->model()::updateOrCreate(
            [
                'user_id' => $userId,
                'reactable_id' => $reactableId,
                'reactable_type' => $reactableType,
            ],
            [
                'type' => $reactionType
            ]
        );
    }

    public function findByComment($commentId, $reactionId, $userId)
    {
        return $this->model()::where('reactable_type', Comment::class)
            ->where('reactable_id', $commentId)
            ->where('user_id', $userId)
            ->findOrFail($reactionId);
    }
}
