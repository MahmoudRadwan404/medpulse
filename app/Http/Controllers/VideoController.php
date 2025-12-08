<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Exception;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string',
                'expert_id' => 'nullable|integer',
                'event_id' => 'nullable|integer',
                'author_id' => 'nullable|integer',
                'article_id' => 'nullable|integer',
                'front_sittings_id' => 'nullable|integer'
            ]);

            $video = Video::create([
                'base_url' => 'https://www.youtube.com/embed/',
                'name' => $request->input("name"),
                'type' => $request->input("type"),
                'expert_id' => $request->input("expert_id") ?? null,
                'event_id' => $request->input("event_id") ?? null,
                'author_id' => $request->input("author_id") ?? null,
                'article_id' => $request->input("article_id") ?? null,
                'front_sittings_id' => $request->input("front_sittings_id") ?? null,
            ]);

            return response()->json([
                'message' => 'Video created successfully',
                'data' => $video
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }


    public function show($id)
    {
        try {
            $video = Video::findOrFail($id);
            return response()->json(['data' => $video]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required|string',
                'type' => 'sometimes|required|string',
                'expert_id' => 'nullable|integer',
                'event_id' => 'nullable|integer',
                'author_id' => 'nullable|integer',
                'article_id' => 'nullable|integer',
                'front_sittings_id' => 'nullable|integer'
            ]);

            $video = Video::findOrFail($id);

            $video->update([
                'name' => $request->input('name', $video->name),
                'type' => $request->input('type', $video->type),
                'expert_id' => $request->input('expert_id') ?? null,
                'event_id' => $request->input('event_id') ?? null,
                'author_id' => $request->input('author_id') ?? null,
                'article_id' => $request->input('article_id') ?? null,
                'front_sittings_id' => $request->input('front_sittings_id') ?? null,
            ]);

            return response()->json([
                'message' => 'Video updated successfully',
                'data' => $video
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }



    public function destroy($id)
    {
        try {
            $video = Video::findOrFail($id);
            $video->delete();

            return response()->json([
                'message' => 'Video deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
