<?php

namespace App\Http\Controllers;

use App\Models\StaticData;
use Illuminate\Http\Request;

class StaticDataController extends Controller
{
    public function create(Request $request)
    {
        $title = $request->input('title');
        $attributes = $request->input('attributes');
        $data = StaticData::create([
            'title' => $title,
            'attributes' => $attributes
        ]);
        return response()->json($data);
    }
    public function findByTitle(Request $request)
    {
        $title = $request->input("title");
        $data = StaticData::where('title', $title)->first();
        return response()->json($data);
    }
    public function findByid( $id)
    {
        $data = StaticData::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $title = $request->input("title");
        $attributes = $request->input("attributes");
        $data = StaticData::where('title', $title)->first();
        $data->update([
            "attributes" => $attributes
        ]);
        return response()->json($data);
    }
}
