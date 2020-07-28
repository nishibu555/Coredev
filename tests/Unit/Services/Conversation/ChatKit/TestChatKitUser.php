<?php

namespace Tests\Unit\Services\Conversation\ChatKit;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestChatKitUser extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $user = new User();
        $chatKitUser = new \App\Services\Conversation\ChatKit\ChatKitUser();
        $chatKitUser->createUser($user->id, $user->name);
        $chatKitUser->authenticate($user->id);
    }
}
