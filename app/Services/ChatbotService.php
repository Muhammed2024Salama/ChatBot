<?php

namespace App\Services;

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
     * @param string $userMessage
     * @return mixed
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function sendMessage(string $userMessage)
    {
        $response = $this->generateAIResponse($userMessage);

        $message = $this->chatbotRepository->storeMessage([
            'user_id' => Auth::id(),
            'message' => $userMessage,
            'response' => $response,
        ]);

        return $message;
    }

    /**
     * @return mixed
     */
    public function history()
    {
        return $this->chatbotRepository->getUserMessages(Auth::id());
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
                [
                    'role' => 'user',
                    'content' => $input,
                ],
            ],
        ]);

        $data = $response->json();

        return $data['choices'][0]['message']['content'] ?? 'No response from AI.';
    }
}
