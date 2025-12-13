<?php

namespace App\Http\Controllers;

use App\Models\FrontSittings;
use Exception;
use Illuminate\Http\Request;

class FrontSettingsController extends Controller
{
    //
    public function create_front_settings(Request $request)
    {
        try {
            $request->validate([
                'mode' => 'required|in:images,video',
            ]);
    
            $mode = $request->input('mode');
            
            // Check if any front settings exist
            $existingSettings = FrontSittings::first();
            
            if ($existingSettings) {
                // Update existing settings
                if ($mode == 'images') {
                    $existingSettings->update([
                        'mode' => $mode,
                        'images' => $request->input('images', 'images'), // Use input or default
                        'video' => null, // Clear video if switching to images
                    ]);
                } else if ($mode == 'video') {
                    $existingSettings->update([
                        'mode' => $mode,
                        'video' => $request->input('video', 'video'), // Use input or default
                        'images' => null, // Clear images if switching to video
                    ]);
                }
                
                return response()->json([
                    'message' => 'Front settings updated successfully',
                    'data' => $existingSettings->fresh()
                ], 200);
                
            } else {
                // Create new settings
                if ($mode == 'images') {
                    $front = FrontSittings::create([
                        'mode' => $mode,
                        'images' => $request->input('images', 'images'),
                        'video' => null,
                    ]);
                } else if ($mode == 'video') {
                    $front = FrontSittings::create([
                        'mode' => $mode,
                        'video' => $request->input('video', 'video'),
                        'images' => null,
                    ]);
                }
                
                return response()->json([
                    'message' => 'Front settings created successfully',
                    'data' => $front
                ], 201);
            }
    
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function get_front_data()
    {
        try {
            $front = FrontSittings::with(['images', 'videos'])->get();
            return response()->json([
                'message' => 'Front data retrieved successfully',
                'data' => $front
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
