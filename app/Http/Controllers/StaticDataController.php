<?php

namespace App\Http\Controllers;

use App\Models\StaticData;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Author;
use App\Models\Event;
use App\Models\Expert;
use App\Models\ContactForm;
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
    public function stats()
    {
        return response()->json([
            'articles' => Article::count(),
            'events'   => Event::count(),
            'experts'  => Expert::count(),
            'authors'  => Author::count(),

            'contact_forms' => [
                'total'    => ContactForm::count(),
                'new'      => ContactForm::where('status', 'new')->count(),
                'opened'   => ContactForm::where('status', 'opened')->count(),
                'answered' => ContactForm::where('status', 'answered')->count(),
            ]
        ]);
    }
}
