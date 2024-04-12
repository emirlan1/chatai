<?php

namespace App\Services;

class ChatGptService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('CHATGPT_API_URL');
        $this->apiKey = env('CHATGPT_API_KEY');
    }

    public function sendMessage($message)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($this->apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'messages' => $message,
                    'max_tokens' => 1000,
                    'temperature' => 0.7,
                    'n' => 1,
                    'stop' => '\n',
                    'model' => 'gpt-3.5-turbo', //gpt-3.5-turbo - БЫЛО
                ]
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return json_decode($response->getBody(), true);
    }
}
