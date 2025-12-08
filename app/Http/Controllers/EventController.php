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
            $event = Event::with(['analysis', 'images', 'videos','authors'])->find($id);
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
                'subjects_description_en' => 'nullable|string',
                'subjects_description_ar' => 'nullable|string',
                'subjects' => 'nullable|array',
                'authors_description_en' => 'nullable|string',
                'authors_description_ar' => 'nullable|string',
                'comments_for_medpulse_en' => 'nullable|string',
                'comments_for_medpulse_ar' => 'nullable|string'
            ]);

            $event = Event::create([
                'title_en' => $request->input("title_en"),
                'title_ar' => $request->input("title_ar"),
                'location' => $request->input("location"),
                'date_of_happening' => $request->input("date_of_happening"),
                'stars' => $request->input("stars") ?? null,
                'rate' => $request->input("rate") ?? null,
                'organizer_en' => $request->input("organizer_en"),
                'organizer_ar' => $request->input("organizer_ar"),
                'description_en' => $request->input("description_en"),
                'description_ar' => $request->input("description_ar"),
                'subjects_description_en' => $request->input("subjects_description_en") ?? null,
                'subjects_description_ar' => $request->input("subjects_description_ar") ?? null,
                'subjects' => $request->input("subjects") ?? null,
                'authors_description_en' => $request->input("authors_description_en") ?? null,
                'authors_description_ar' => $request->input("authors_description_ar") ?? null,
                'comments_for_medpulse_en' => $request->input("comments_for_medpulse_en") ?? null,
                'comments_for_medpulse_ar' => $request->input("comments_for_medpulse_ar") ?? null,
            ]);

            return response()->json([
                'message' => 'Event created successfully',
                'data' => $event
            ], 201);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title_en' => 'sometimes|required|string|max:255',
                'title_ar' => 'sometimes|required|string|max:255',
                'location' => 'sometimes|required|string|max:255',
                'date_of_happening' => 'sometimes|required|date',
                'stars' => 'nullable|integer|min:0|max:5',
                'rate' => 'nullable|numeric|min:0|max:10',
                'organizer_en' => 'sometimes|required|string|max:255',
                'organizer_ar' => 'sometimes|required|string|max:255',
                'description_en' => 'sometimes|required|string',
                'description_ar' => 'sometimes|required|string',
                'subjects_description_en' => 'nullable|string',
                'subjects_description_ar' => 'nullable|string',
                'subjects' => 'nullable|array',
                'authors_description_en' => 'nullable|string',
                'authors_description_ar' => 'nullable|string',
                'comments_for_medpulse_en' => 'nullable|string',
                'comments_for_medpulse_ar' => 'nullable|string'
            ]);

            $event = Event::findOrFail($id);

            $event->update([
                'title_en' => $request->input('title_en', $event->title_en),
                'title_ar' => $request->input('title_ar', $event->title_ar),
                'location' => $request->input('location', $event->location),
                'date_of_happening' => $request->input('date_of_happening', $event->date_of_happening),
                'stars' => $request->input('stars') ?? $event->stars,
                'rate' => $request->input('rate') ?? $event->rate,
                'organizer_en' => $request->input('organizer_en', $event->organizer_en),
                'organizer_ar' => $request->input('organizer_ar', $event->organizer_ar),
                'description_en' => $request->input('description_en', $event->description_en),
                'description_ar' => $request->input('description_ar', $event->description_ar),
                'subjects_description_en' => $request->input('subjects_description_en') ?? $event->subjects_description_en,
                'subjects_description_ar' => $request->input('subjects_description_ar') ?? $event->subjects_description_ar,
                'subjects' => $request->input('subjects') ?? $event->subjects,
                'authors_description_en' => $request->input('authors_description_en') ?? $event->authors_description_en,
                'authors_description_ar' => $request->input('authors_description_ar') ?? $event->authors_description_ar,
                'comments_for_medpulse_en' => $request->input('comments_for_medpulse_en') ?? $event->comments_for_medpulse_en,
                'comments_for_medpulse_ar' => $request->input('comments_for_medpulse_ar') ?? $event->comments_for_medpulse_ar,
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
}