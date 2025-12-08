<?php

namespace App\Http\Controllers;

use App\Models\Sitting;
use Exception;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Event;
class SettingsController extends Controller
{
    // Get settings or create if not exists
    public function get_or_create(Request $request)
    {
        try {
            // Check if settings exist
            $settings = Sitting::first();

            if (!$settings) {
                // Create default settings
                $settings = Sitting::create([
                    'posts_number' => 3, // default value
                    'events_number' => 3, // default value
                ]);

                return response()->json([
                    'message' => 'Default settings created successfully',
                    'data' => $settings
                ], 201);
            }

            return response()->json([
                'message' => 'Settings retrieved successfully',
                'data' => $settings
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }



    // Update settings
    public function update(Request $request)
    {
        try {
            $request->validate([
                'posts_number' => 'sometimes|integer|min:1',
                'events_number' => 'sometimes|integer|min:1'
            ]);

            // Get or create settings
            $settings = Sitting::first();

            if (!$settings) {
                // Create settings with provided values or defaults
                $settings = Sitting::create([
                    'posts_number' => $request->input('posts_number', 6),
                    'events_number' => $request->input('events_number', 3),
                ]);

                return response()->json([
                    'message' => 'Settings created successfully',
                    'data' => $settings
                ], 201);
            }

            // Update settings
            $settings->update($request->all());
            return response()->json([
                'message' => 'Settings updated successfully',
                'data' => $settings
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function events_articles()
    {
        try {
            $settings = Sitting::first();

            // If no settings exist, create defaults
            if (!$settings) {
                $settings = Sitting::create([
                    'posts_number' => 6,
                    'events_number' => 3
                ]);
            }

            $articles = Article::with(['images'])
                ->latest()
                ->take($settings->posts_number)
                ->get();

            $events = Event::with(['images'])
                ->latest()
                ->take($settings->events_number)
                ->get();

            return response()->json([
                'message' => 'Articles and events retrieved successfully',
                'data' => [
                    'articles' => $articles,
                    'events' => $events,
                    'settings' => [
                        'posts_per_page' => $settings->posts_number,
                        'events_per_page' => $settings->events_number
                    ]
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}