<?php

namespace App\Services;

use JDecool\OllamaClient\Client;
use JDecool\OllamaClient\Client\Message;
use JDecool\OllamaClient\Client\Request\ChatRequest;
use JDecool\OllamaClient\ClientBuilder;

class OllamaService
{
    private Client $client;
    private string $model = 'openchat';

    public function __construct()
    {
        $builder = new ClientBuilder();
        $this->client = $builder->create();
    }

    public function ask(array $questions)
    {
        $messages = array_map([$this, 'createMessage'], $questions);
        $request = new ChatRequest($this->model, $messages);
        return $this->client->chatStream($request);
    }

    private function createMessage($questions)
    {
        return new Message($questions['role'], $questions['content']);
    }
}
