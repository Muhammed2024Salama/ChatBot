<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Helper\ResponseHelper;

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
        try {
            $message = $this->chatbotService->sendMessage($request->message);

            return ResponseHelper::success(
                message: 'Message sent successfully.',
                data: new MessageResource($message)
            );
        } catch (\Exception $e) {
            return ResponseHelper::error(
                message: 'Failed to send message: ' . $e->getMessage(),
                statusCode: 500
            );
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function history()
    {
        try {
            $messages = $this->chatbotService->history();

            return ResponseHelper::success(
                message: 'Message history retrieved successfully.',
                data: MessageResource::collection($messages)
            );
        } catch (\Exception $e) {
            return ResponseHelper::error(
                message: 'Failed to fetch history: ' . $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
