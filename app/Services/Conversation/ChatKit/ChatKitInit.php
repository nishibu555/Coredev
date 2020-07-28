<?php


namespace App\Services\Conversation\ChatKit;


use Chatkit\Chatkit;

class ChatKitInit
{
    protected $chatkit = '';

    public function __construct()
    {
        $config = config('broadcasting.connections.pusher_chatkit');
        $this->chatkit = new Chatkit(
            [
                'instance_locator' => $config['instance_locator'],
                'key' => $config['secret_key']
            ]
        );
    }

    protected function toString($data): string
    {
        return (string)$data;
    }
}
