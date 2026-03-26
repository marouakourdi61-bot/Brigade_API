<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IngredientController extends Controller
{
    use AuthorizesRequests;

    // 

    public function index()
    {
        $this->authorize('viewAny', Ingredient::class);

        $ingredients = Ingredient::all();

        return response()->json($ingredients, 200);
    }

    // Creer  

    public function store(Request $request)
    {
        $this->authorize('create', Ingredient::class);

        $data = $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name',
            'tags' => 'nullable|array',
            'tags.*' => 'in:contains_meat,contains_sugar,contains_cholesterol,contains_gluten,contains_lactose'
        ]);

        $ingredient = Ingredient::create([
            'name' => $data['name'],
            'tags' => $data['tags'] ?? []
        ]);

        return response()->json($ingredient, 201);
    }


    public function update(Request $request, Ingredient $ingredient)
    {
        $this->authorize('update', $ingredient);

        $data = $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name,' . $ingredient->id,
            'tags' => 'nullable|array',
            'tags.*' => 'in:contains_meat,contains_sugar,contains_cholesterol,contains_gluten,contains_lactose'
        ]);

        $ingredient->update([
            'name' => $data['name'],
            'tags' => $data['tags'] ?? []
        ]);
        

        return response()->json([
            'message' => 'Ingrédient mis à jour avec succès',
            'ingredient' => $ingredient
        ], 200);
    }

    // Supprimer  (admin)
     
    public function destroy(Ingredient $ingredient)
    {
        $this->authorize('delete', $ingredient);

        $ingredient->delete();

        return response()->json([
            'message' => 'Ingrédient supprimé avec succès'
        ], 200);
    }

}
