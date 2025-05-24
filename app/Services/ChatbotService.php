<?php

namespace App\Services;

use App\Events\MessageSentEvent;
use App\Helper\ResponseHelper;
use App\Http\Resources\MessageResource;
use App\Interface\ChatbotInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatbotService
{
    /**
     * @var ChatbotInterface
     */
    protected $chatbotRepository;

    /**
     * @param ChatbotInterface $chatbotRepository
     */
    public function __construct(ChatbotInterface $chatbotRepository)
    {
        $this->chatbotRepository = $chatbotRepository;
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(array $data)
    {
        try {
            $userId = Auth::id();
            $response = $this->generateAIResponse($data['message']);

            $message = $this->chatbotRepository->storeMessage([
                'user_id' => $userId,
                'message' => $data['message'],
                'response' => $response,
            ]);

            broadcast(new MessageSentEvent($message))->toOthers();

            return ResponseHelper::success('Message sent successfully.', new MessageResource($message));
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to send message: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistory()
    {
        try {
            $messages = $this->chatbotRepository->getUserMessages(Auth::id());
            return ResponseHelper::success('Message history retrieved successfully.', MessageResource::collection($messages));
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to fetch history: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @param string $input
     * @return string
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    private function generateAIResponse(string $input): string
    {
        $apiKey = config('services.openai.api_key');

        $response = Http::withToken($apiKey)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $input],
            ],
        ]);

        $data = $response->json();

        return $data['choices'][0]['message']['content'] ?? 'No response from AI.';
    }
}
