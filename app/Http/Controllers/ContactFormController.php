<?php

namespace App\Http\Controllers;

use App\Mail\ReplyContactForm;
use App\Models\Contact;
use App\Models\ContactForm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'organisation' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'number' => 'required|string|max:20',
                'asking_type' => 'required|string|max:255',
                'details' => 'required|string',
                'status' => 'nullable|string|max:255' //new opened replied
            ]);

            $contact = ContactForm::create([
                'full_name' => $request->input('full_name'),
                'organisation' => $request->input('organisation'),
                'email' => $request->input('email'),
                'number' => $request->input('number'),
                'asking_type' => $request->input('asking_type'),
                'details' => $request->input('details'),
                'status' => $request->input('status', 'new'), // default status
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
            $contacts = ContactForm::query();

            // Optional filtering
            if ($request->has('status')) {
                $contacts->where('status', $request->input('status'));
            }

            if ($request->has('asking_type')) {
                $contacts->where('asking_type', $request->input('asking_type'));
            }

            // Search functionality
            if ($request->has('search')) {
                $search = $request->input('search');
                $contacts->where(function ($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('organisation', 'like', "%{$search}%")
                        ->orWhere('details', 'like', "%{$search}%");
                });
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
            $contact = ContactForm::findOrFail($id);
            if ($contact->status == 'new') {
                $contact->status = 'opened';
                $contact->save();
            }
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
            $contact = ContactForm::findOrFail($id);

            $request->validate([
                'full_name' => 'sometimes|required|string|max:255',
                'organisation' => 'nullable|string|max:255',
                'email' => 'sometimes|required|email|max:255',
                'number' => 'sometimes|required|string|max:20',
                'asking_type' => 'sometimes|required|string|max:255',
                'details' => 'sometimes|required|string',
                'status' => 'nullable|string|max:255'
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
            $contact = ContactForm::findOrFail($id);
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

    public function updateStatus(Request $request, $id)
    {
        try {
            $contact = ContactForm::findOrFail($id);

            $request->validate([
                'status' => 'required|string|max:255'
            ]);

            $contact->update([
                'status' => $request->input('status')
            ]);

            return response()->json([
                'message' => 'Contact status updated successfully',
                'data' => $contact
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function reply($id, Request $request)
    {
        try {
            $contact = ContactForm::findOrFail($id);
            $email = $contact->email;
            $content = $request->input('content');
            Mail::to($email)->send(mailable: new ReplyContactForm($content, $contact));//
            $contact->status = 'asnwered';
            $contact->save();
            return response()->json(["status" => "success", 'message' => "sent successfully"]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function notification(){
        $number = ContactForm::where('status', "new")->count();
        return response()->json(['new_contacts' => $number]);
    }
}