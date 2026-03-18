<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Afficher le profil
    public function show()
    {
        $user = Auth::user();
        return response()->json($user);
    }

   
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated =  $request->validate([
            'dietary_tags' => 'array',
            'dietary_tags.*' => 'in:vegan,no_sugar,no_cholesterol,gluten_free,no_lactose',
        ]);

        $user->update($validated);

        return response()->json($request->user());
    }
}