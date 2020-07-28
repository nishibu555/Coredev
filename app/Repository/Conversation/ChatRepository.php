<?php


namespace Repository\Conversation;


use App\Models\Conversation\Chat;
use App\Models\Conversation\Conversation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Repository\Repository;

class ChatRepository extends Repository
{
    public function model()
    {
        return Chat::class;
    }

    public function getChatWith($userId)
    {
        return $this->model::where([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId
        ])->orWhere([
            'receiver_id' => auth()->id(),
            'sender_id' => $userId
        ])
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function storeMessageBy(Conversation $conversation, string $text, array $images = [], array $files = [])
    {
        $message = collect([
           'text' => $text,
           'images' => $this->storeFiles($images),
           'files' => $this->storeFiles($files)
        ]);
        return $conversation->chats()->create([
                'message' => json_encode($message),
                'user_id' => auth()->id(),
                'message_type' => 'message'
            ]);
    }

    public function sendMetaBy(Conversation $conversation, string $meta)
    {
        return $conversation->chats()->create([
            'message' => $meta,
            'user_id' => auth()->id(),
            'message_type' => 'meta'
        ]);
    }

    public function getMessageBy(Conversation $conversation)
    {
        return $conversation->chats->load('sender');
    }

    private function storeFiles(array $files): Collection
    {
        $storeFiles = collect([]);
        foreach ($files as $file) {
            $storeFiles->push($this->storeFile($file));
        }
        return $storeFiles;
    }

    private function storeFile($file)
    {
        return Storage::disk('public')->put('chats', $file);
    }
}
