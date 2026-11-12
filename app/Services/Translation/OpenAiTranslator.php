<?php

namespace App\Services\Translation;

use App\Models\MessageTranslation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenAiTranslator
{
    private string $apiKey;

    private string $baseUrl;

    private string $model;

    public function __construct()
    {
        $this->apiKey = (string) config('services.openai.key', '');
        $this->baseUrl = (string) (config('services.openai.base_url', 'https://api.openai.com/v1') ?: 'https://api.openai.com/v1');
        $this->model = (string) (config('services.openai.model', 'gpt-5-mini') ?: 'gpt-5-mini');
    }

    public function translate(string $text, string $toLanguage, ?string $fromLanguage = null): string
    {
        if ($text === '') {
            return $text;
        }

        $to = $toLanguage;
        $from = $fromLanguage;

        $hash = $this->hash($text, $to, $from);

        $cached = MessageTranslation::where('source_hash', $hash)
            ->where('target_language', $to)
            ->first();

        if ($cached) {
            return $cached->translated_text;
        }

        $response = Http::withToken($this->apiKey)
            ->timeout(60)
            ->post($this->baseUrl.'/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a precise, culturally neutral translator. Translate messages to the target language naturally and concisely. Do not add explanations, notes, or formatting. Only return the translated text.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $from ? "Translate from {$from} to {$to}: {$text}" : "Translate to {$to}: {$text}",
                    ],
                ],
                'temperature' => (float) config('services.openai.temperature', 0),
            ]);

        $translated = $response->json('choices.0.message.content') ?? $text;

        if (is_string($translated) && trim($translated) !== '') {
            try {
                MessageTranslation::create([
                    'source_hash' => $hash,
                    'source_language' => $from,
                    'target_language' => $to,
                    'source_text' => $text,
                    'translated_text' => Str::of($translated)->trim()->toString(),
                ]);
            } catch (\Throwable $e) {
                // Ignore cache write failures
            }
        }

        return is_string($translated) ? trim($translated) : $text;
    }

    private function hash(string $text, string $to, ?string $from): string
    {
        $payload = ($from ? $from.'|' : '').$to.'|'.$text;

        return hash('sha256', $payload);
    }
}
