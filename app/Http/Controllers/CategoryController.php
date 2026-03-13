<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
      use AuthorizesRequests;


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::where('user_id', Auth::id())->get();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class); 

        $request->validate([
            'name' =>  ['required', 'string', 'max:255'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrFail( $id);
         
        $this->authorize('view', $category);

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $categorie)
    {
        $this->authorize('update', $categorie);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:300'],
        ]);

        $categorie->update($data);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'categorie' => $categorie,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Category $categorie)
    {
        $this->authorize('delete', $categorie);

        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès',
        ], 200);
    }
}