<?php


namespace Repository\Post;


use App\Models\Comment;
use App\Models\Post;
use App\Models\User\User;
use Illuminate\Support\Collection;
use Repository\Repository;

class CommentRepository extends Repository
{

    public function model()
    {
        return Comment::class;
    }

  public function findByPost($postId, $commentId, $userId)
  {
       return $this->model()::where('post_id', $postId)->where('user_id', $userId)->findOrFail($commentId);
  }
}
