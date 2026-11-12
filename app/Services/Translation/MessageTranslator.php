<?php

namespace App\Services\Translation;

use App\Data\Languages;
use Illuminate\Support\Facades\Auth;

class MessageTranslator
{
    public function __construct(private readonly GeminiTranslator $translator) {}

    /**
     * Translate a message to the viewer's preferred language, if different from source.
     */
    public function translateMessage(string $message, ?string $sourceLanguage = null, ?string $viewerLanguage = null): string
    {
        $to = Languages::resolve($viewerLanguage ?? Auth::user()?->preferred_language);

        if (! $this->shouldTranslate($message, $sourceLanguage, $to)) {
            return $message;
        }

        try {
            return $this->translator->translate($message, $to, $sourceLanguage);
        } catch (\Throwable $e) {
            return $message;
        }
    }

    private function shouldTranslate(string $message, ?string $sourceLanguage, string $to): bool
    {
        if ($this->apiKeyMissing()) {
            return false;
        }

        if (trim($message) === '') {
            return false;
        }

        if ($sourceLanguage && Languages::resolve($sourceLanguage) === $to) {
            return false;
        }

        return true;
    }

    private function apiKeyMissing(): bool
    {
        $key = config('services.gemini.key');

        return empty($key);
    }
}
