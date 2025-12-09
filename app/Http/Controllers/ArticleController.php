<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Exception;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:article_categories,id',
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'description_en' => 'required|string',
                'description_ar' => 'required|string'
            ]);

            $article = Article::create([
                'category_id' => $request->input('category_id'),
                'title_en' => $request->input('title_en'),
                'title_ar' => $request->input('title_ar'),
                'description_en' => $request->input('description_en'),
                'description_ar' => $request->input('description_ar'),
            ]);

            return response()->json([
                'message' => 'Article created successfully',
                'data' => $article
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
            $articles = Article::with(['images'])->paginate(6);

            return response()->json([
                'data' => $articles
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
            $article = Article::with(['authors', 'images', 'videos'])->findOrFail($id);
            return response()->json([
                'data' => $article
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->delete();

            return response()->json([
                'message' => 'Article deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'category_id' => 'sometimes|required|exists:article_categories,id',
                'title_en' => 'sometimes|required|string|max:255',
                'title_ar' => 'sometimes|required|string|max:255',
                'description_en' => 'sometimes|required|string',
                'description_ar' => 'sometimes|required|string'
            ]);

            $article = Article::findOrFail($id);

            // Update only provided fields
            $updateData = [];
            if ($request->has('category_id')) {
                $updateData['category_id'] = $request->input('category_id');
            }
            if ($request->has('title_en')) {
                $updateData['title_en'] = $request->input('title_en');
            }
            if ($request->has('title_ar')) {
                $updateData['title_ar'] = $request->input('title_ar');
            }
            if ($request->has('description_en')) {
                $updateData['description_en'] = $request->input('description_en');
            }
            if ($request->has('description_ar')) {
                $updateData['description_ar'] = $request->input('description_ar');
            }

            $article->update($updateData);

            return response()->json([
                'message' => 'Article updated successfully',
                'data' => $article
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

}
