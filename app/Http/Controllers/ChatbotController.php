<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Services\ChatbotService;

class ChatbotController extends Controller
{
    /**
     * @var ChatbotService
     */
    protected $chatbotService;

    /**
     * @param ChatbotService $chatbotService
     */
    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * @param SendMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(SendMessageRequest $request)
    {
        return $this->chatbotService->sendMessage($request->validated());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function history()
    {
        return $this->chatbotService->getHistory();
    }
}
