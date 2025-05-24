<?php

namespace App\Interface;

interface ChatbotInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function storeMessage(array $data);

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserMessages(int $userId);
}
