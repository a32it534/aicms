<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GapGptService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.gapgpt.base_url'), '/');
        $this->apiKey  = (string) config('services.gapgpt.key');
        $this->model   = (string) config('services.gapgpt.model');

        if ($this->apiKey === '') {
            throw new RuntimeException('کلید GAPGPT_API_KEY تنظیم نشده است.');
        }
    }

    /**
     * تولید محتوای ساختاریافته: عنوان، خلاصه، متن، کلمات کلیدی
     */
    public function generateArticle(string $prompt, string $tone = 'رسمی', int $words = 600): array
    {
        $system = <<<SYS
تو یک نویسنده حرفه‌ای محتوای فارسی هستی.
خروجی را فقط به صورت JSON معتبر و بدون هیچ متن اضافه برگردان با کلیدهای:
title (رشته)، summary (رشته کوتاه)، body (متن HTML ساده با تگ‌های p, h2, ul, li)، keywords (رشته، جدا شده با ویرگول).
SYS;

        $user = "موضوع: {$prompt}\nلحن: {$tone}\nطول تقریبی متن: {$words} کلمه.";

        $data = $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user',   'content' => $user],
        ], jsonMode: true);

        $parsed = $this->parseJson($data);

        return [
            'title'    => (string) ($parsed['title'] ?? mb_substr($prompt, 0, 120)),
            'summary'  => (string) ($parsed['summary'] ?? ''),
            'body'     => (string) ($parsed['body'] ?? $data),
            'keywords' => is_array($parsed['keywords'] ?? null)
                ? implode('، ', $parsed['keywords'])
                : (string) ($parsed['keywords'] ?? ''),
            'model'    => $this->model,
        ];
    }

    /** درخواست خام چت */
    public function chat(array $messages, bool $jsonMode = false): string
    {
        $payload = [
            'model'       => $this->model,
            'messages'    => $messages,
            'temperature' => 0.7,
        ];

        if ($jsonMode) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->timeout(180)
            ->retry(2, 1500, throw: false)
            ->post($this->baseUrl . '/chat/completions', $payload);

        if ($response->failed()) {
            $message = $response->json('error.message') ?? $response->body();
            throw new RuntimeException('خطای سرویس هوش مصنوعی ('
                . $response->status() . '): ' . $message);
        }

        return (string) ($response->json('choices.0.message.content') ?? '');
    }

    protected function parseJson(string $raw): array
    {
        $clean = trim(preg_replace('/^```(?:json)?|```$/m', '', $raw) ?? $raw);
        $decoded = json_decode($clean, true);

        return is_array($decoded) ? $decoded : [];
    }
}
