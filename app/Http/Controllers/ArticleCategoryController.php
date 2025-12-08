<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use Exception;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|max:255|unique:article_categories,name_en',
                'name_ar' => 'required|string|max:255|unique:article_categories,name_ar'
            ]);

            $category = ArticleCategory::create([
                'name_en' => $request->input('name_en'),
                'name_ar' => $request->input('name_ar'),
            ]);

            return response()->json([
                'message' => 'Category created successfully',
                'data' => $category
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
            $categories = ArticleCategory::all();

            return response()->json([
                'data' => $categories
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
            $category = ArticleCategory::with('articles')->findOrFail($id);
            return response()->json([
                'data' => $category
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
                'name_en' => 'sometimes|string|max:255|unique:article_categories,name_en,' . $id,
                'name_ar' => 'sometimes|string|max:255|unique:article_categories,name_ar,' . $id
            ]);

            $category = ArticleCategory::findOrFail($id);

            $category->update([
                'name_en' => $request->input('name_en'),
                'name_ar' => $request->input('name_ar'),
            ]);

            return response()->json([
                'message' => 'Category updated successfully',
                'data' => $category
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
            $category = ArticleCategory::findOrFail($id);
            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
