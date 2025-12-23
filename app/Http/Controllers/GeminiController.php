<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Event;
use App\Models\Expert;
use App\Models\StaticData;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeminiController extends Controller
{
    //
    function testAi(Request $request)
    {
        try {
            // Initialize the service
            $gemini = new GeminiService();
            $sent = $request->input('data');

            $prompt1 = <<<PROMPT
            You are an intent detector.
            Classify the user message into ONE of these intents ONLY:
            - info
            - start_form
            - submit_form
            Rules:
            - Respond with ONLY a valid string
            - Do NOT add explanations
            - Do NOT use markdown
            - Do NOT return extra fields
            format:
            info , start_form, submit_form
            User message:
            "$sent"
            PROMPT;

            $response = $gemini->generateText($prompt1);

            if ($response == 'info') {
                $experts = Expert::with('contacts')->get();
                $articles = Article::with(['category', 'authors'])->get();
                $events = Event::with(['analysis'])->get();

                // Convert collections to JSON strings BEFORE using in heredoc
                $expertsJson = json_encode($experts, JSON_UNESCAPED_UNICODE);
                $articlesJson = json_encode($articles, JSON_UNESCAPED_UNICODE);
                $eventsJson = json_encode($events, JSON_UNESCAPED_UNICODE);

                // Use concatenation instead of heredoc interpolation
                $prompt2 = "DATABASE CONTEXT:

EXPERTS:
" . $expertsJson . "

ARTICLES:
" . $articlesJson . "

EVENTS:
" . $eventsJson . "

USER QUESTION:
\"" . $sent . "\"

RULES:
- Use ONLY the database context
- If not found, reply with general talk about website and end it with that all what i know
- Use exact titles/names
- Respond with ONLY valid string
- No markdown, no extra text
- Answer with the language you asked by in user question

ANSWER:";

                $response = $gemini->generateText($prompt2);
                return response()->json([
                    'success' => true,
                    'prompt' => $sent,
                    'response' => $response
                ]);

            } else if ($response == 'start_form') {
                $prompt3 = <<<PROMPT
                You are assisting with collecting collaboration information.
                
                REQUIRED FIELDS:
                - full_name
                - organisation
                - email
                - number
                - asking_type (General Inquiry, Event Information, Expert Consultation, Partnership Request, Technical Support, Other)
                - details
                
                RULES:
                1. Ask the user to provide ALL required fields in ONE message.
                2. Be polite, friendly, and professional.
                3. Briefly explain why the information is needed (in one sentence).
                4. If the user provides partial information, acknowledge it and ask them to resend ALL fields together.
                5. Do NOT ask for the fields one by one.
                6. Do NOT include markdown or bullet points.
                7. Keep the message concise and conversational.
                
                USER MESSAGE:
                "{$sent}"
                
                RESPONSE:
                PROMPT;

                $response = $gemini->generateText($prompt3);
                return response()->json([
                    'success' => true,
                    'prompt' => $sent,
                    'response' => $response
                ]);

            } else if ($response == 'submit_form') {
                $prompt4 = "You must return ONLY valid JSON. No markdown code blocks, no backticks, no explanations, no additional text before or after.

                Extract these fields from the user's input:
                - full_name (string, required)
                - organisation (string, required)
                - email (string, required)
                - number (string, required)
                - asking_type (string, required)
                - details (string, required)
                
                If any REQUIRED field is missing, return an error response in this format:
                {
                    \"success\": false,
                    \"error\": \"Validation failed\",
                    \"errors\": {
                        \"full_name\": [\"Full name is required\"],
                        \"email\": [\"Email is required\"],
                        \"number\": [\"Number is required\"],
                        \"asking_type\": [\"Asking type is required\"],
                        \"details\": [\"Details is required\"]
                    }
                } for the missing one only
                
                If all required fields are present, return the extracted data in this format:
                {
                    \"success\": true,
                    \"data\": {
                        \"full_name\": \"value\",
                        \"organisation\": \"value or null\",
                        \"email\": \"value\",
                        \"number\": \"value\",
                        \"asking_type\": \"value\",
                        \"details\": \"value\"
                    }
                }
                
                User input: " . $sent . "
                
                Response (JSON only, no markdown):";
                $response = $gemini->generateText($prompt4);
                $data = json_decode($response, true);
                // Output the clean JSON

                return response()->json($data);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function addKeyModel(Request $request)
    {
        $key = $request->input('key');
        $model = $request->input('model');
        $gemini = StaticData::updateOrCreate(
            ["title" => "gemini"],
            [
                "attributes" => json_encode(
                    [
                        "key" => $key,
                        "model" => $model
                    ]
                )
            ]
        );
        return response()->json($gemini);
    }
}