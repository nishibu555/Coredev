<?php


namespace Repository\Conversation;


use App\Models\Conversation\Conversation;
use App\Models\Conversation\ConversationMember;
use Repository\Repository;

class MemberRepository extends Repository
{

    public function model()
    {
        return ConversationMember::class;
    }
}
