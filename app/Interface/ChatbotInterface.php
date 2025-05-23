<?php

namespace App\Interface;

interface ChatbotInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function storeMessage($data);

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserMessages($userId);
}
