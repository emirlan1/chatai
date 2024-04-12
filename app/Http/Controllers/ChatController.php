<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Services\ChatGptService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatGptService;

    public function __construct(ChatGptService $chatGptService)
    {
        $this->chatGptService = $chatGptService;
    }

    public function index(Request $request, $id = null)
    {
        try {
            if ($request->isMethod('post')) {
                if ($request->input('id')) {
                    $chat = Chat::findOrFail($request->input('id'));
                    $messages = $chat->context;
                }
                $messages[] = ['role' => 'user', 'content' => $request->input('prompt')];
                $response = $this->chatGptService->sendMessage($messages);
                $messages[] = ['role' => 'assistant', 'content' => $response['choices'][0]['message']['content']];
                $chat = Chat::updateOrCreate([
                    'id' => $request->input('id'),
                    'user_id' => 1
                ],
                    [
                        'context' => $messages
                    ]);

                return response()->json(['response' => $response, 'chat_id' => $chat->id]);
            }
        } catch (\Exception $e) {
            dd([$e->getMessage(), $e->getLine()]);
        }

        $chats = Chat::all();
        return view('chat', ['chats' => $chats]);
    }

    public function context(Request $request)
    {
        $messages = [];
        if ($request->isMethod('post')) {
            if ($request->input('id')) {
                $chat = Chat::findOrFail($request->input('id'));
                $messages = $chat->context;
            }
        }
        return view('chatscreen', ['messages' => $messages]);
    }

    public function chatList(Request $request)
    {
        $chatLists = [];
        if ($request->isMethod('post')) {
            $chatLists = Chat::all();
        }
        return view('chatlist', ['chats' => $chatLists]);
    }
}
