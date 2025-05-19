<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $userMessage = $request->input('message');

        $response = $this->getBotResponse($userMessage);

        Message::create([
            'message' => $userMessage,
            'response' => $response,
        ]);

        return response()->json([
            'message' => $userMessage,
            'response' => $response,
        ]);
    }

    /**
     * @param $message
     * @return string
     */
    private function getBotResponse($message)
    {
        if (str_contains(strtolower($message), 'hello')) {
            return "Hi there! How can I help you?";
        }

        return "I'm still learning. Please ask something else!";
    }
}
