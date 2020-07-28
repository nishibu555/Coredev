<?php


namespace Repository\Post;


use App\Models\Post;
use App\Models\User\User;
use Illuminate\Support\Collection;
use Repository\Repository;

class PostRepository extends Repository
{

    public function model()
    {
        return Post::class;
    }

    private function checkByUserId($userId)
    {
      return  $this->model()::where('user_id', $userId);
    }

    public function findById($userId, $postId)
    {
       return $this->checkByUserId($userId)->findOrFail($postId);
    }

    public function getByUser($userId, $perPage)
    {
      return  $this->checkByUserId($userId)->paginate($perPage);
    }

    public function getByConnection($connectionIds, $perPage = 15)
    {
        return $this->model()::whereIn('user_id', $connectionIds)->paginate($perPage);
    }
}
