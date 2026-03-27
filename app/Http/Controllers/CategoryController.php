<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // CLIENT
   

    // GET 
    public function index()
    {
        return response()->json(
            Category::where('is_active', true)->get(),
            200
        );
    }

    
    public function showPlates(Category $category)
    {
        return response()->json(
            $category->plats()
                ->where('is_available', true)
                ->get(),
            200
        );
    }

    // ADMIN
     

    // POST 
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $category = Category::create($data);

        return response()->json($category, 201);
    }

    // GET
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    // PUT 
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $category->update($data);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'category' => $category
        ], 200);
    }

    // DELETE 
    public function destroy(Category $category)
    {
        
        if ($category->plats()->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer une catégorie contenant des plats'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ], 200);
    }
}