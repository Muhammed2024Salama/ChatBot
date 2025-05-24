<?php

namespace App\Repository;

use App\Interface\ChatbotInterface;
use App\Models\Message;

class ChatbotRepository implements ChatbotInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function storeMessage(array $data)
    {
        return Message::create($data);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserMessages(int $userId)
    {
        return Message::where('user_id', $userId)->latest()->get();
    }
}
