<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plat;
use App\Models\Category;

class PlatController extends Controller
{
    // CLIENT
     

    // GET 
    public function index()
    {
        return response()->json(
            Plat::with('category')
                ->where('is_available', true)
                ->get(),
            200
        );
    }

    // GET 
    public function show(Plat $plat)
    {
        return response()->json(
            $plat->load('category', 'ingredients'),
            200
        );
    }

    // ADMIN
     

    // POST 
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'is_available' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'ingredient_ids' => 'array'
        ]);

        $plat = Plat::create($data);

        // relation manytomany
        if ($request->has('ingredient_ids')) {
            $plat->ingredients()->sync($request->ingredient_ids);
        }

        return response()->json($plat, 201);
    }

    // POST 
    public function storeByCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'is_available' => 'boolean',
            'ingredient_ids' => 'array'
        ]);

        $data['category_id'] = $category->id;

        $plat = Plat::create($data);

        if ($request->has('ingredient_ids')) {
            $plat->ingredients()->sync($request->ingredient_ids);
        }

        return response()->json($plat, 201);
    }

    // PUT 
    public function update(Request $request, Plat $plat)
    {
        $data = $request->validate([
            'name' => 'string|max:100',
            'description' => 'nullable|string',
            'price' => 'numeric|min:0',
            'image' => 'nullable|string',
            'is_available' => 'boolean',
            'category_id' => 'exists:categories,id',
            'ingredient_ids' => 'array'
        ]);

        $plat->update($data);

        if ($request->has('ingredient_ids')) {
            $plat->ingredients()->sync($request->ingredient_ids);
        }

        return response()->json($plat);
    }

    // DELETE 
    public function destroy(Plat $plat)
    {
        $plat->delete();

        return response()->json([
            'message' => 'Plat supprimé avec succès'
        ]);
    }
}