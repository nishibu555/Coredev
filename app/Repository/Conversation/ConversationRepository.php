<?php


namespace Repository\Conversation;


use App\Models\Conversation\Conversation;
use App\Models\User\User;
use Repository\Repository;

class ConversationRepository extends Repository
{

    public function model()
    {
        return Conversation::class;
    }

    public function ofUser(User $userData)
    {
        return $this->model()::whereHas('users', function ($member) use ($userData) {
            $member->where('user_id', $userData->id);
        })->with([
            'users' => function ($user) use ($userData) {
                $user->wherePivot('user_id','!=', $userData->id)->get(['users.id', 'users.first_name', 'users.last_name']);
            }
        ])
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function addMembers(Conversation $conversation, array $membersId)
    {
        $conversation->users()->attach($membersId);
    }
}
