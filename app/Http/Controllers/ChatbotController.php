<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $botResponse = $this->generateResponse($request->message);

        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'response' => $botResponse,
        ]);

        return response()->json([
            'message' => $message->message,
            'response' => $message->response,
            'created_at' => $message->created_at,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function history()
    {
        $messages = Message::where('user_id', Auth::id())->latest()->get();
        return response()->json($messages);
    }

    /**
     * @param $input
     * @return string
     */
    private function generateResponse($input)
    {
        $input = strtolower($input);
        return match (true) {
            str_contains($input, 'hello') => 'Hi! How can I help you?',
            str_contains($input, 'price') => 'Our prices vary based on the product.',
            str_contains($input, 'muhammed') => 'Muhammed is a software developer and laravel developer.',
            default => 'Sorry, I did not understand that.',
        };
    }
}
