<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Plat;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Category;




class PlatController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Plat::class);

        $plats = Plat::where('user_id', Auth::id())->get();
        return response()->json($plats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Plat::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $plat = Plat::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json($plat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plat $plat)
    {
        $this->authorize('view', $plat);

        return response()->json($plat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plat = Plat::findOrFail($id);
        $this->authorize('update', $plat);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $plat->update($request->only(['name', 'description', 'price', 'category_id']));
        return response()->json($plat->load('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plat = Plat::findOrFail($id);
        $this->authorize('delete', $plat);

        $plat->delete();
        return response()->json(['message' => 'Plat supprimé avec succès']);
    }

    public function storeByCategory(Request $request, Category $category)
    {
        $this->authorize('create', Plat::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric'
        ]);

        $plat = $category->plats()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'user_id' => auth()->id()
        ]);

        return response()->json($plat, 201);
    }
}