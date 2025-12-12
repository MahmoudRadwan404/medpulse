<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Exception;

class EventController extends Controller
{
    public function index()
    {
        try {
            $events = Event::with(['images'])->paginate(6);
            return response()->json(['data' => $events]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $event = Event::with(['analysis', 'images', 'videos', 'authors'])->find($id);
            return response()->json(['data' => $event]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'date_of_happening' => 'required|date',
                'stars' => 'nullable|integer|min:0|max:5',
                'rate' => 'nullable|numeric|min:0|max:10',
                'organizer_en' => 'required|string|max:255',
                'organizer_ar' => 'required|string|max:255',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                // Accept arrays directly (Laravel will handle JSON conversion)
                'subjects_description_en' => 'nullable|array',
                'subjects_description_en.*' => 'nullable|string',
                'subjects_description_ar' => 'nullable|array',
                'subjects_description_ar.*' => 'nullable|string',
                'subjects_en' => 'nullable|array',
                'subjects_en.*' => 'nullable|string|max:255',
                'subjects_ar' => 'nullable|array',
                'subjects_ar.*' => 'nullable|string|max:255',
                'authors_description_en' => 'nullable|string',
                'authors_description_ar' => 'nullable|string',
                'comments_for_medpulse_en' => 'nullable|string',
                'comments_for_medpulse_ar' => 'nullable|string'
            ]);

            $event = Event::create(// For creating/updating events
                [
                    'title_en' => $request->input("title_en"),
                    'title_ar' => $request->input("title_ar"),
                    'location' => $request->input("location"),
                    'date_of_happening' => $request->input("date_of_happening"),
                    'stars' => $request->input("stars") ?? 0, // Default to 0 instead of null
                    'rate' => $request->input("rate") ?? 0, // Default to 0 instead of null
                    'organizer_en' => $request->input("organizer_en"),
                    'organizer_ar' => $request->input("organizer_ar"),
                    'description_en' => $request->input("description_en"),
                    'description_ar' => $request->input("description_ar"),
                    // JSON array fields - ensure they're arrays
                    'subjects_description_en' => $request->input("subjects_description_en") ?? [],
                    'subjects_description_ar' => $request->input("subjects_description_ar") ?? [],
                    'subjects_en' => $request->input("subjects_en") ?? [], // NEW FIELD
                    'subjects_ar' => $request->input("subjects_ar") ?? [], // NEW FIELD
                    'authors_description_en' => $request->input("authors_description_en") ?? null,
                    'authors_description_ar' => $request->input("authors_description_ar") ?? null,
                    'comments_for_medpulse_en' => $request->input("comments_for_medpulse_en") ?? null,
                    'comments_for_medpulse_ar' => $request->input("comments_for_medpulse_ar") ?? null,
                ],

            );
            return response()->json(['message' => "Event created successfully", 'data' => $event]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title_en' => 'sometimes|nullable|string|max:255',
                'title_ar' => 'sometimes|nullable|string|max:255',
                'location' => 'sometimes|nullable|string|max:255',
                'date_of_happening' => 'sometimes|nullable|date',
                'stars' => 'sometimes|nullable|integer|min:0|max:5',
                'rate' => 'sometimes|nullable|numeric|min:0|max:10',
                'organizer_en' => 'sometimes|nullable|string|max:255',
                'organizer_ar' => 'sometimes|nullable|string|max:255',
                'description_en' => 'sometimes|nullable|string',
                'description_ar' => 'sometimes|nullable|string',
                'subjects_description_en' => 'sometimes|nullable|array',
                'subjects_description_en.*' => 'nullable|string',
                'subjects_description_ar' => 'sometimes|nullable|array',
                'subjects_description_ar.*' => 'nullable|string',
                'subjects_en' => 'sometimes|nullable|array',
                'subjects_en.*' => 'nullable|string|max:255',
                'subjects_ar' => 'sometimes|nullable|array',
                'subjects_ar.*' => 'nullable|string|max:255',
                'authors_description_en' => 'sometimes|nullable|string',
                'authors_description_ar' => 'sometimes|nullable|string',
                'comments_for_medpulse_en' => 'sometimes|nullable|string',
                'comments_for_medpulse_ar' => 'sometimes|nullable|string'
            ]);

            $event = Event::findOrFail($id);

            $event->update([
                'title_en' => $request->filled('title_en') ? $request->input('title_en') : $event->title_en,
                'title_ar' => $request->filled('title_ar') ? $request->input('title_ar') : $event->title_ar,
                'location' => $request->filled('location') ? $request->input('location') : $event->location,
                'date_of_happening' => $request->filled('date_of_happening') ? $request->input('date_of_happening') : $event->date_of_happening,
                'stars' => $request->filled('stars') ? $request->input('stars') : $event->stars,
                'rate' => $request->filled('rate') ? $request->input('rate') : $event->rate,
                'organizer_en' => $request->filled('organizer_en') ? $request->input('organizer_en') : $event->organizer_en,
                'organizer_ar' => $request->filled('organizer_ar') ? $request->input('organizer_ar') : $event->organizer_ar,
                'description_en' => $request->filled('description_en') ? $request->input('description_en') : $event->description_en,
                'description_ar' => $request->filled('description_ar') ? $request->input('description_ar') : $event->description_ar,
                'subjects_description_en' => $request->filled('subjects_description_en') ? $request->input('subjects_description_en') : $event->subjects_description_en,
                'subjects_description_ar' => $request->filled('subjects_description_ar') ? $request->input('subjects_description_ar') : $event->subjects_description_ar,
                'subjects_en' => $request->filled('subjects_en') ? $request->input('subjects_en') : $event->subjects_en,
                'subjects_ar' => $request->filled('subjects_ar') ? $request->input('subjects_ar') : $event->subjects_ar,
                'authors_description_en' => $request->filled('authors_description_en') ? $request->input('authors_description_en') : $event->authors_description_en,
                'authors_description_ar' => $request->filled('authors_description_ar') ? $request->input('authors_description_ar') : $event->authors_description_ar,
                'comments_for_medpulse_en' => $request->filled('comments_for_medpulse_en') ? $request->input('comments_for_medpulse_en') : $event->comments_for_medpulse_en,
                'comments_for_medpulse_ar' => $request->filled('comments_for_medpulse_ar') ? $request->input('comments_for_medpulse_ar') : $event->comments_for_medpulse_ar,
            ]);

            return response()->json([
                'message' => 'Event updated successfully',
                'data' => $event
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::with(['analysis', 'images', 'videos'])->find($id);
            $event->delete();

            return response()->json([
                'message' => 'Event deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function attach_author_to_event(Request $request)
    {
        try {
            $event_id = $request->input('event_id');
            $author_id = $request->input('author_id');
            $event = Event::findOrFail($event_id);
            $event->authors()->attach($author_id);
            $event->load('authors');
            return response()->json([
                'message' => 'Author attached to event successfully',
                'data' => $event
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function detach_author_from_event(Request $request)
    {
        try {
            $event_id = $request->input('event_id');
            $author_id = $request->input('author_id');
            $event = Event::findOrFail($event_id);
            $event->authors()->detach($author_id);
            $event->load('authors');
            return response()->json([
                'message' => 'Author detached from event successfully',
                'data' => $event
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function events_filter(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'title_ar' => 'nullable|string|max:255',
                'title_en' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'date_of_happening' => 'nullable|date',
                'total' => 'nullable|numeric',
            ]);

            // Check if at least one search parameter is provided
            if (!$request->hasAny(['title_ar', 'title_en', 'location', 'date_of_happening', 'total'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'At least one search parameter is required',
                    'errors' => [
                        'search' => ['Please provide at least one filter: title_ar, title_en, location, date_of_happening, or total']
                    ]
                ], 422);
            }

            // Build query with when() clauses
            $query = Event::with('analysis');

            // Filter by Arabic title
            if ($request->filled('title_ar')) {
                $query->where('title_ar', 'LIKE', '%' . $validated['title_ar'] . '%');
            }

            // Filter by English title
            if ($request->filled('title_en')) {
                $query->where('title_en', 'LIKE', '%' . $validated['title_en'] . '%');
            }

            // Filter by location
            if ($request->filled('location')) {
                $query->where('location', 'LIKE', '%' . $validated['location'] . '%');
            }

            // Filter by date of happening
            if ($request->filled('date_of_happening')) {
                $query->whereDate('date_of_happening', $validated['date_of_happening']);
            }

            // Filter by analysis total rating
            if ($request->filled('total')) {
                $query->whereHas('analysis', function ($q) use ($validated) {
                    $q->where('total', '>=', $validated['total']);
                });
            }

            // Execute query
            $events = $query->get();

            // Check if results found
            if ($events->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No events found matching your criteria',
                    'data' => [],
                    'count' => 0
                ], 200);
            }

            // Return successful response
            return response()->json([
                'success' => true,
                'message' => 'Events retrieved successfully',
                'data' => $events,
                'count' => $events->count()
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            // Handle other errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while filtering events',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

}