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
            $mode = $request->input('mode');
            if ($mode == 'images') {
                $front = FrontSittings::create([
                    'mode' => $mode,
                    'images' => 'images'
                ]);
            } else if ($mode == 'video') {
                $front = FrontSittings::create([
                    'mode' => $mode,
                    'video' => 'video'
                ]);
            }
            return response()->json([
                'message' => 'Front settings created successfully',
                'data' => $front
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function get_front_data($id)
    {
        try {
            $front = FrontSittings::with(['images', 'videos'])->findOrFail($id);
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
