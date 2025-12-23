<?php

namespace App\Services;

use App\Models\StaticData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Request;

class GeminiService
{
    private $apiKey;
    private $model;
    
    public function __construct()
    {
        $data = StaticData::where('title', 'gemini')->first();

        if (
            !$data ||
            !($attributes = json_decode($data->attributes, true)) ||
            !isset($attributes['key'], $attributes['model'])
        ) {
            throw new \Exception('Invalid or missing Gemini configuration');
        }
        
        $this->apiKey = $attributes['key'];
        $this->model  = $attributes['model'];
        
    }//env('GEMINI_API_KEY')||env('GEMINI_MODEL', 'gemini-1.5-flash')||

    /**
     * Generate text from prompt
     */
    public function generateText( $prompt, array $options = [])
    {
        try {
            // Correct API endpoint with proper model name
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

            // Make the API request
            $response = Http::timeout(60)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => array_merge([
                    'temperature' => 0.7,
                    'maxOutputTokens' => 2048,
                    'topK' => 40,
                    'topP' => 0.95,
                ], $options)
            ]);

            // Check if request failed
            if ($response->failed()) {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? 'Unknown error';
                Log::error('Gemini API Request Failed', [
                    'status' => $response->status(),
                    'error' => $errorMessage,
                    'body' => $response->body()
                ]);
                throw new \Exception("API Request failed: {$errorMessage}");
            }

            // Parse the response
            $data = $response->json();

            // Extract the text from response
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                return $data['candidates'][0]['content']['parts'][0]['text'];
            }

            // Check for safety ratings that might block content
            if (isset($data['candidates'][0]['finishReason']) && 
                $data['candidates'][0]['finishReason'] === 'SAFETY') {
                throw new \Exception('Content was blocked due to safety settings');
            }

            // Check for errors in response
            if (isset($data['error'])) {
                throw new \Exception('API Error: ' . $data['error']['message']);
            }

            throw new \Exception('No text in response: ' . json_encode($data));

        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate text with streaming (optional)
     */
    public function generateTextStream( $prompt, array $options = [])
    {
        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:streamGenerateContent?key={$this->apiKey}";

            $response = Http::timeout(60)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => array_merge([
                    'temperature' => 0.7,
                    'maxOutputTokens' => 2048,
                ], $options)
            ]);

            return $response->body();

        } catch (\Exception $e) {
            Log::error('Gemini API Streaming Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * List available models
     */
    public function listModels()
    {
        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models?key={$this->apiKey}";
            
            $response = Http::get($url);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            throw new \Exception('Failed to list models');
            
        } catch (\Exception $e) {
            Log::error('Gemini List Models Error: ' . $e->getMessage());
            throw $e;
        }
    }
}