<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use Illuminate\Http\Request;
use Exception;

class ExpertController extends Controller
{
    public function index()
    {
        try {
            $experts = Expert::with(['images', 'videos', 'contacts']) // if you have image relationship
                ->paginate(6);
            return response()->json(['data' => $experts]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $expert = Expert::with(['images', 'videos', 'contacts'])
                ->findOrFail($id);
            return response()->json(['data' => $expert]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'job_en' => 'required|string|max:255',
                'job_ar' => 'required|string|max:255',
                'medpulse_role_en' => 'required|string|max:255',
                'medpulse_role_ar' => 'required|string|max:255',
                'medpulse_role_description_en' => 'required|string',
                'medpulse_role_description_ar' => 'required|string',
                'current_job_en' => 'required|string|max:255',
                'current_job_ar' => 'required|string|max:255',
                'coverage_type_en' => 'required|string|max:255',
                'coverage_type_ar' => 'required|string|max:255',
                'evaluated_specialties_en' => 'nullable|array',
                'evaluated_specialties_ar' => 'nullable|array',
                'number_of_events' => 'nullable|integer|min:0',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'years_of_experience' => 'nullable|integer|min:0',
                'subspecialities_en' => 'nullable|array',
                'membership_en' => 'nullable|array',
                'subspecialities_ar' => 'nullable|array',
                'membership_ar' => 'nullable|array'
            ]);

            $expert = Expert::create([
                'name_en' => $request->input("name_en"),
                'name_ar' => $request->input("name_ar"),
                'job_en' => $request->input("job_en"),
                'job_ar' => $request->input("job_ar"),
                'medpulse_role_en' => $request->input("medpulse_role_en"),
                'medpulse_role_ar' => $request->input("medpulse_role_ar"),
                'medpulse_role_description_en' => $request->input("medpulse_role_description_en"),
                'medpulse_role_description_ar' => $request->input("medpulse_role_description_ar"),
                'current_job_en' => $request->input("current_job_en"),
                'current_job_ar' => $request->input("current_job_ar"),
                'coverage_type_en' => $request->input("coverage_type_en"),
                'coverage_type_ar' => $request->input("coverage_type_ar"),
                'evaluated_specialties_en' => $request->input("evaluated_specialties_en") ?? null,
                'evaluated_specialties_ar' => $request->input("evaluated_specialties_ar") ?? null,
                'number_of_events' => $request->input("number_of_events") ?? null,
                'description_en' => $request->input("description_en"),
                'description_ar' => $request->input("description_ar"),
                'years_of_experience' => $request->input("years_of_experience") ?? null,
                'subspecialities_en' => $request->input("subspecialities_en") ?? null,
                'membership_en' => $request->input("membership_en") ?? null,
                'subspecialities_ar' => $request->input("subspecialities_ar") ?? null,
                'membership_ar' => $request->input("membership_ar") ?? null,
            ]);

            return response()->json([
                'message' => 'Expert created successfully',
                'data' => $expert
            ], 201);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name_en' => 'sometimes|required|string|max:255',
                'name_ar' => 'sometimes|required|string|max:255',
                'job_en' => 'sometimes|required|string|max:255',
                'job_ar' => 'sometimes|required|string|max:255',
                'medpulse_role_en' => 'sometimes|required|string|max:255',
                'medpulse_role_ar' => 'sometimes|required|string|max:255',
                'medpulse_role_description_en' => 'sometimes|required|string',
                'medpulse_role_description_ar' => 'sometimes|required|string',
                'current_job_en' => 'sometimes|required|string|max:255',
                'current_job_ar' => 'sometimes|required|string|max:255',
                'coverage_type_en' => 'sometimes|required|string|max:255',
                'coverage_type_ar' => 'sometimes|required|string|max:255',
                'evaluated_specialties_en' => 'nullable|array',
                'evaluated_specialties_ar' => 'nullable|array',
                'number_of_events' => 'nullable|integer|min:0',
                'description_en' => 'sometimes|required|string',
                'description_ar' => 'sometimes|required|string',
                'years_of_experience' => 'nullable|integer|min:0',
                'subspecialities_en' => 'nullable|array',
                'membership_en' => 'nullable|array',
                'subspecialities_ar' => 'nullable|array',
                'membership_ar' => 'nullable|array'
            ]);

            $expert = Expert::findOrFail($id);

            $expert->update([
                'name_en' => $request->input('name_en', $expert->name_en),
                'name_ar' => $request->input('name_ar', $expert->name_ar),
                'job_en' => $request->input('job_en', $expert->job_en),
                'job_ar' => $request->input('job_ar', $expert->job_ar),
                'medpulse_role_en' => $request->input('medpulse_role_en', $expert->medpulse_role_en),
                'medpulse_role_ar' => $request->input('medpulse_role_ar', $expert->medpulse_role_ar),
                'medpulse_role_description_en' => $request->input('medpulse_role_description_en', $expert->medpulse_role_description_en),
                'medpulse_role_description_ar' => $request->input('medpulse_role_description_ar', $expert->medpulse_role_description_ar),
                'current_job_en' => $request->input('current_job_en', $expert->current_job_en),
                'current_job_ar' => $request->input('current_job_ar', $expert->current_job_ar),
                'coverage_type_en' => $request->input('coverage_type_en', $expert->coverage_type_en),
                'coverage_type_ar' => $request->input('coverage_type_ar', $expert->coverage_type_ar),
                'evaluated_specialties_en' => $request->input('evaluated_specialties_en') ?? $expert->evaluated_specialties_en,
                'evaluated_specialties_ar' => $request->input('evaluated_specialties_ar') ?? $expert->evaluated_specialties_ar,
                'number_of_events' => $request->input('number_of_events') ?? $expert->number_of_events,
                'description_en' => $request->input('description_en', $expert->description_en),
                'description_ar' => $request->input('description_ar', $expert->description_ar),
                'years_of_experience' => $request->input('years_of_experience') ?? $expert->years_of_experience,
                'subspecialities_en' => $request->input('subspecialities_en') ?? $expert->subspecialities_en,
                'membership_en' => $request->input('membership_en') ?? $expert->membership_en,
                'subspecialities_ar' => $request->input('subspecialities_ar') ?? $expert->subspecialities_ar,
                'membership_ar' => $request->input('membership_ar') ?? $expert->membership_ar,
            ]);

            return response()->json([
                'message' => 'Expert updated successfully',
                'data' => $expert
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $expert = Expert::findOrFail($id);
            $expert->delete();

            return response()->json([
                'message' => 'Expert deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'job' => 'nullable|string',
                'specialty' => 'nullable|string',
                'coverage_type' => 'nullable|string'
            ]);

            $query = Expert::query();

            if ($request->has('name')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name_en', 'like', '%' . $request->name . '%')
                        ->orWhere('name_ar', 'like', '%' . $request->name . '%');
                });
            }

            if ($request->has('job')) {
                $query->where(function ($q) use ($request) {
                    $q->where('job_en', 'like', '%' . $request->job . '%')
                        ->orWhere('job_ar', 'like', '%' . $request->job . '%');
                });
            }

            if ($request->has('coverage_type')) {
                $query->where(function ($q) use ($request) {
                    $q->where('coverage_type_en', 'like', '%' . $request->coverage_type . '%')
                        ->orWhere('coverage_type_ar', 'like', '%' . $request->coverage_type . '%');
                });
            }

            $experts = $query->get();

            return response()->json(['data' => $experts]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}