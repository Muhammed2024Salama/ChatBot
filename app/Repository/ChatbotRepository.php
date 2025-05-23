<?php

namespace App\Repository;

use App\Interface\ChatbotInterface;
use App\Models\Message;

class ChatbotRepository implements ChatbotInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function storeMessage($data)
    {
        return Message::create($data);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserMessages($userId)
    {
        return Message::where('user_id', $userId)->latest()->get();
    }
}
