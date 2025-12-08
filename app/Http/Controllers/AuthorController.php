<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'speciality_ar' => 'required|string',
                'speciality_en' => 'required|string'
            ]);
            $author = Author::create([
                'name_en' => $request->input('name_en'),
                'name_ar' => $request->input('name_ar'),
                'speciality_ar' => $request->input('speciality_ar'),
                'speciality_en' => $request->input('speciality_en')
            ]);
            return response()->json([
                'message' => 'Author created successfully',
                'data' => $author
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function index()
    {
        try {
            $authors = Author::all();

            return response()->json([
                'data' => $authors
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $author = Author::findOrFail($id);

            return response()->json([
                'data' => $author
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name_en' => 'sometimes|required|string|max:255',
                'name_ar' => 'sometimes|required|string|max:255',
                'speciality_ar' => 'sometimes|required|string',
                'speciality_en' => 'sometimes|required|string'
            ]);

            $author = Author::findOrFail($id);

            // Update only provided fields
            $updateData = [];
            if ($request->has('name_en')) {
                $updateData['name_en'] = $request->input('name_en');
            }
            if ($request->has('name_ar')) {
                $updateData['name_ar'] = $request->input('name_ar');
            }
            if ($request->has('speciality_ar')) {
                $updateData['speciality_ar'] = $request->input('speciality_ar');
            }
            if ($request->has('speciality_en')) {
                $updateData['speciality_en'] = $request->input('speciality_en');
            }

            $author->update($updateData);

            return response()->json([
                'message' => 'Author updated successfully',
                'data' => $author
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function destroy($id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->delete();

            return response()->json([
                'message' => 'Author deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function attach_author_to_article(Request $request)
    {
        try {
            $article_id = $request->input('article_id');
            $author_id = $request->input('author_id');
            $article = Article::findOrFail($article_id);
            $article->authors()->attach($author_id);
            $article->load('authors');
            return response()->json([
                'message' => 'Author attached to article successfully',
                'data' => $article
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function detach_author_from_article(Request $request)
{
    try {
        $article_id = $request->input('article_id');
        $author_id = $request->input('author_id');
        $article = Article::findOrFail($article_id);
        $article->authors()->detach($author_id);
        $article->load('authors');
        return response()->json([
            'message' => 'Author detached from article successfully',
            'data' => $article
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 422);
    }
}
}

