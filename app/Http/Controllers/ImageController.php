<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //
    public function create(Request $request)
    {

        //     $path = $request->file('image')->store('newPhoto', 'public');
        //     $type = $request->file('image')->getMimeType();
        //     $fullname='/storage/'.$path;
        //     //   Image::create([
        //     //         'type' => $request->input('type'),//profile,thumbnail,content
        //     //         'articel_id' => $request->input('article_id'),
        //     //         'author_id' => $request->input('author_id'),
        //     //         'event_id' => $request->input('event_id'),
        //     //     ]);
        // return response([$fullname,$type]);
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            'images.*.file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images.*.type' => 'required',
            'images.*.expert_id' => 'nullable|exists:experts,id',
            'images.*.event_id' => 'nullable|exists:events,id',
            'images.*.author_id' => 'nullable|exists:authors,id',
            'images.*.article_id' => 'nullable|exists:articles,id',
            'images.*.front_sittings_id' => 'nullable|exists:front_sittings,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedImages = [];

        foreach ($request->file('images') as $index => $imageData) {
            // Get the uploaded file
            $file = $imageData['file'];

            // Generate unique filename
            // $filename = time() . '_' . $index . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file in storage/app/public
            $path = $file->store('newPhoto', 'public');

            // Create database record
            $image = Image::create([
                'base_url' => '/storage/',
                'name' => $path,
                'type' => $request->input("images.$index.type"),
                'expert_id' => $request->input("images.$index.expert_id") ?? null,
                'event_id' => $request->input("images.$index.event_id") ?? null,
                'author_id' => $request->input("images.$index.author_id") ?? null,
                'article_id' => $request->input("images.$index.article_id") ?? null,
                'front_sittings_id' => $request->input("images.$index.front_sittings_id") ?? null,
            ]);

            $uploadedImages[] = [
                'id' => $image->id,
                'url' => asset('storage/' . $path),
                'type' => $image->type,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully',
            'data' => $uploadedImages
        ], 201);
    }
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        
        // Delete file from storage
        $filePath = str_replace('/storage/', '', $image->name);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        
        // Delete database record
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ], 200);
    }
}

