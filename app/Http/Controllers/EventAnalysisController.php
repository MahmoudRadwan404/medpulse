<?php

namespace App\Http\Controllers;

use App\Models\EventAnalysis;
use Illuminate\Http\Request;
use Exception;

class EventAnalysisController extends Controller
{
    public function index()
    {
        try {
            $analyses = EventAnalysis::with('event')->get();
            return response()->json(['data' => $analyses]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $analysis = EventAnalysis::with('event')->findOrFail($id);
            return response()->json(['data' => $analysis]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function getByEvent($eventId)
    {
        try {
            $analysis = EventAnalysis::where('event_id', $eventId)
                                    ->with('event')
                                    ->firstOrFail();
            return response()->json(['data' => $analysis]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Analysis not found for this event'], 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required|integer|unique:event_analyses,event_id',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'content_rate' => 'required|numeric|min:0|max:10',
                'content_rate_description_en' => 'required|string',
                'content_rate_description_ar' => 'required|string',
                'organisation_rate' => 'required|numeric|min:0|max:10',
                'organisation_rate_description_en' => 'required|string',
                'organisation_rate_description_ar' => 'required|string',
                'speaker_rate' => 'required|numeric|min:0|max:10',
                'speaker_rate_description_en' => 'required|string',
                'speaker_rate_description_ar' => 'required|string',
                'sponsering_rate' => 'required|numeric|min:0|max:10',
                'sponsering_rate_description_en' => 'required|string',
                'sponsering_rate_description_ar' => 'required|string',
                'scientific_impact_rate' => 'required|numeric|min:0|max:10',
                'scientific_impact_rate_description_en' => 'required|string',
                'scientific_impact_rate_description_ar' => 'required|string'
            ]);

            $total = (
                $request->input('content_rate') +
                $request->input('organisation_rate') +
                $request->input('speaker_rate') +
                $request->input('sponsering_rate') +
                $request->input('scientific_impact_rate')
            ) / 5;

            $analysis = EventAnalysis::create([
                'event_id' => $request->input("event_id"),
                'description_en' => $request->input("description_en"),
                'description_ar' => $request->input("description_ar"),
                'content_rate' => $request->input("content_rate"),
                'content_rate_description_en' => $request->input("content_rate_description_en"),
                'content_rate_description_ar' => $request->input("content_rate_description_ar"),
                'organisation_rate' => $request->input("organisation_rate"),
                'organisation_rate_description_en' => $request->input("organisation_rate_description_en"),
                'organisation_rate_description_ar' => $request->input("organisation_rate_description_ar"),
                'speaker_rate' => $request->input("speaker_rate"),
                'speaker_rate_description_en' => $request->input("speaker_rate_description_en"),
                'speaker_rate_description_ar' => $request->input("speaker_rate_description_ar"),
                'sponsering_rate' => $request->input("sponsering_rate"),
                'sponsering_rate_description_en' => $request->input("sponsering_rate_description_en"),
                'sponsering_rate_description_ar' => $request->input("sponsering_rate_description_ar"),
                'scientific_impact_rate' => $request->input("scientific_impact_rate"),
                'scientific_impact_rate_description_en' => $request->input("scientific_impact_rate_description_en"),
                'scientific_impact_rate_description_ar' => $request->input("scientific_impact_rate_description_ar"),
                'total' => round($total, 2)
            ]);

            return response()->json([
                'message' => 'Event analysis created successfully',
                'data' => $analysis
            ], 201);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'event_id' => 'sometimes|required|integer|unique:event_analysis,event_id,' . $id,
                'description_en' => 'sometimes|required|string',
                'description_ar' => 'sometimes|required|string',
                'content_rate' => 'sometimes|required|numeric|min:0|max:10',
                'content_rate_description_en' => 'sometimes|required|string',
                'content_rate_description_ar' => 'sometimes|required|string',
                'organisation_rate' => 'sometimes|required|numeric|min:0|max:10',
                'organisation_rate_description_en' => 'sometimes|required|string',
                'organisation_rate_description_ar' => 'sometimes|required|string',
                'speaker_rate' => 'sometimes|required|numeric|min:0|max:10',
                'speaker_rate_description_en' => 'sometimes|required|string',
                'speaker_rate_description_ar' => 'sometimes|required|string',
                'sponsering_rate' => 'sometimes|required|numeric|min:0|max:10',
                'sponsering_rate_description_en' => 'sometimes|required|string',
                'sponsering_rate_description_ar' => 'sometimes|required|string',
                'scientific_impact_rate' => 'sometimes|required|numeric|min:0|max:10',
                'scientific_impact_rate_description_en' => 'sometimes|required|string',
                'scientific_impact_rate_description_ar' => 'sometimes|required|string'
            ]);

            $analysis = EventAnalysis::findOrFail($id);
            
            $content_rate = $request->input('content_rate', $analysis->content_rate);
            $organisation_rate = $request->input('organisation_rate', $analysis->organisation_rate);
            $speaker_rate = $request->input('speaker_rate', $analysis->speaker_rate);
            $sponsering_rate = $request->input('sponsering_rate', $analysis->sponsering_rate);
            $scientific_impact_rate = $request->input('scientific_impact_rate', $analysis->scientific_impact_rate);
            
            $total = (
                $content_rate +
                $organisation_rate +
                $speaker_rate +
                $sponsering_rate +
                $scientific_impact_rate
            ) / 5;

            $analysis->update([
                'event_id' => $request->input('event_id', $analysis->event_id),
                'description_en' => $request->input('description_en', $analysis->description_en),
                'description_ar' => $request->input('description_ar', $analysis->description_ar),
                'content_rate' => $content_rate,
                'content_rate_description_en' => $request->input('content_rate_description_en', $analysis->content_rate_description_en),
                'content_rate_description_ar' => $request->input('content_rate_description_ar', $analysis->content_rate_description_ar),
                'organisation_rate' => $organisation_rate,
                'organisation_rate_description_en' => $request->input('organisation_rate_description_en', $analysis->organisation_rate_description_en),
                'organisation_rate_description_ar' => $request->input('organisation_rate_description_ar', $analysis->organisation_rate_description_ar),
                'speaker_rate' => $speaker_rate,
                'speaker_rate_description_en' => $request->input('speaker_rate_description_en', $analysis->speaker_rate_description_en),
                'speaker_rate_description_ar' => $request->input('speaker_rate_description_ar', $analysis->speaker_rate_description_ar),
                'sponsering_rate' => $sponsering_rate,
                'sponsering_rate_description_en' => $request->input('sponsering_rate_description_en', $analysis->sponsering_rate_description_en),
                'sponsering_rate_description_ar' => $request->input('sponsering_rate_description_ar', $analysis->sponsering_rate_description_ar),
                'scientific_impact_rate' => $scientific_impact_rate,
                'scientific_impact_rate_description_en' => $request->input('scientific_impact_rate_description_en', $analysis->scientific_impact_rate_description_en),
                'scientific_impact_rate_description_ar' => $request->input('scientific_impact_rate_description_ar', $analysis->scientific_impact_rate_description_ar),
                'total' => round($total, 2)
            ]);

            return response()->json([
                'message' => 'Event analysis updated successfully',
                'data' => $analysis
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $analysis = EventAnalysis::findOrFail($id);
            $analysis->delete();

            return response()->json([
                'message' => 'Event analysis deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}