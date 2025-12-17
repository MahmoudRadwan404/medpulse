<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Event;
use App\Models\Expert;
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
            $sent = $request->input("data");

            //$sentString = json_encode($sent, JSON_UNESCAPED_UNICODE);
            // Make a simple request
            //$prompt = "i want to use you as intent detector for this sentence give me one of the three options {info , form start form submit} $sent";
            //$prompt = "make json object of{organisation,email,number,asking_type,details} from $sentString and validate it response should only contains json object with the key i gave you to be ";
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
                //  $context = [$experts, $events, $articles];
                $prompt2 = <<<PROMPT
                DATABASE CONTEXT:
                
                EXPERTS:
                {$experts}
                
                ARTICLES:
                {$articles}
                
                EVENTS:
                {$events}
                
                USER QUESTION:
                "{$sent}"
                
                RULES:
                - Use ONLY the database context
                - If not found, reply with general talk about website and end it with that all whatr i know
                - Use exact titles/names
                - Respond with ONLY valid string
                - No markdown, no extra text
                -answer with the language you asked by in user question
                
                ANSWER:
                PROMPT;

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
                return response('heelo from third');

            }
            
            //            $response = $gemini->listModels();
            // $clean = preg_replace('/```json|```/i', '', $response);
            // $data = json_decode(trim($clean), true);

            /*  $validator = Validator::make($data, [
                  'organisation' => 'required|string|min:3|max:255',
                  'email' => 'required|email',
                  'number' => [
                      'required',
                      'string',
                      'regex:/^\+?[0-9\s\-\(\)]{7,20}$/'
                  ],
                  'asking_type' => 'required|string|max:100',
                  'details' => 'required|string|min:10',
              ]);
              // 3️⃣ Check for errors

              if ($validator->fails()) {
                  return response()->json([
                      'success' => false,
                      'errors' => $validator->errors()->getMessages(),
                  ], 422);
              }*/
            // return response()->json([
            //     'success' => true,
            //   //  'prompt' => $prompt,
            //     'response' => $data
            // ]);

        } catch (\Exception $e) {


            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}