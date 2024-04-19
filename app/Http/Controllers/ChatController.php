<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Services\ChatGptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

                $chat = Chat::firstOrCreate([
                    'id' => $request->input('id'),
                    'user_id' => Auth::id()
                ],
                [
                    'name' => 'blablabla'
                ]);

                //Запись сообщения пользователя
                $message = new Message([
                    'chat_id' => $chat->id,
                    'user_type' => 1,
                    'message' => $request->input('prompt')
                ]);
                $message->save();

                //Запрос к боту
                $messages[] = ['role' => 'user', 'content' => $request->input('prompt')];
                $response = $this->chatGptService->sendMessage($messages);

                //Запись Ответа Бота
                $message = new Message([
                    'chat_id' => $chat->id,
                    'user_type' => 0,
                    'message' => $response['choices'][0]['message']['content']
                ]);
                $message->save();

                return response()->json(['response' => $response, 'chat_id' => $chat->id]);
            }
        } catch (\Exception $e) {
            dd([$e->getMessage(), $e->getLine()]);
        }

        $chats = Chat::where('user_id', Auth::id())->get();
        return view('chat', ['chats' => $chats]);
    }

    public function context(Request $request)
    {
        $messages = [];
        if ($request->isMethod('post')) {
            if ($request->input('id')) {
                try {
                    $chat = Chat::where('id', $request->input('id'))->where('user_id', Auth::id())->first();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
                $messages = $chat->messages;
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
