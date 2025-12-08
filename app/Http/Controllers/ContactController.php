<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'link' => 'required|url|max:500',
                'expert_id' => 'nullable|exists:experts,id' // assuming experts table exists
            ]);

            $contact = Contact::create([
                'name_en' => $request->input('name_en'),
                'name_ar' => $request->input('name_ar'),
                'link' => $request->input('link'),
                'expert_id' => $request->input('expert_id'),
            ]);

            return response()->json([
                'message' => 'Contact created successfully',
                'data' => $contact
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    public function index(Request $request)
    {
        try {
            $contacts = Contact::query();
            
            // Optional filtering by expert_id
            if ($request->has('expert_id')) {
                $contacts->where('expert_id', $request->input('expert_id'));
            }
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->input('search');
                $contacts->where(function($query) use ($search) {
                    $query->where('name_en', 'like', "%{$search}%")
                        ->orWhere('name_ar', 'like', "%{$search}%")
                        ->orWhere('link', 'like', "%{$search}%");
                });
            }
            
            // Language-specific search
            if ($request->has('name_en')) {
                $contacts->where('name_en', 'like', "%{$request->input('name_en')}%");
            }
            
            if ($request->has('name_ar')) {
                $contacts->where('name_ar', 'like', "%{$request->input('name_ar')}%");
            }
            
            // Sorting
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            $contacts->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->input('per_page', 15);
            $contacts = $contacts->paginate($perPage);
            
            return response()->json([
                'message' => 'Contacts retrieved successfully',
                'data' => $contacts
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $contact = Contact::with('expert')->findOrFail($id);
            
            return response()->json([
                'message' => 'Contact retrieved successfully',
                'data' => $contact
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Contact not found'
            ], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            
            $request->validate([
                'name_en' => 'sometimes|required|string|max:255',
                'name_ar' => 'sometimes|required|string|max:255',
                'link' => 'sometimes|required|url|max:500',
                'expert_id' => 'nullable|exists:experts,id'
            ]);
            
            $contact->update($request->all());
            
            return response()->json([
                'message' => 'Contact updated successfully',
                'data' => $contact
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            
            return response()->json([
                'message' => 'Contact deleted successfully'
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Contact not found'
            ], 404);
        }
    } 
}