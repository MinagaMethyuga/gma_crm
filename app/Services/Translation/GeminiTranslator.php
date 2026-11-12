<?php

namespace App\Services\Translation;

use App\Models\MessageTranslation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GeminiTranslator
{
    private string $apiKey;

    private string $baseUrl;

    private string $model;

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.key', '');
        $this->baseUrl = (string) (config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta') ?: 'https://generativelanguage.googleapis.com/v1beta');
        $this->model = (string) (config('services.gemini.model', 'gemini-2.5-flash-lite') ?: 'gemini-2.5-flash-lite');
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

        $system = 'You are a precise, culturally neutral translator. Translate messages to the target language naturally and concisely. Do not add explanations, notes, or formatting. Only return the translated text.';
        $user = $from ? "Translate from {$from} to {$to}: {$text}" : "Translate to {$to}: {$text}";

        $url = rtrim($this->baseUrl, '/').'/models/'.$this->model.':generateContent?key='.$this->apiKey;

        $response = Http::timeout(60)
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $user],
                        ],
                    ],
                ],
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $system],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => (float) config('services.gemini.temperature', 0),
                ],
            ]);

        $translated = $response->json('candidates.0.content.parts.0.text') ?? $text;

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
