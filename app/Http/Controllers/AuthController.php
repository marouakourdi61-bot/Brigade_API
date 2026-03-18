<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Inscription d'un nouvel utilisateur
     */
    public function register(Request $request)
    {

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', 
            'role' => 'required|in:admin,client',
        ]);

        // Création user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Création  token
        $token = $user->createToken('auth_token')->plainTextToken;

        // JSON
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Connexion de l'utilisateur
     */
    public function login(Request $request)
    {

        // Validation 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        // token 
        $token = $user->createToken('auth_token')->plainTextToken;

        // JSON
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        // Supprimer token 

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnecté avec succès.'
        ]);
    }

    /**
     * Récupérer l'utilisateur connecté
     */
    public function user(Request $request)
    {
        
        return response()->json($request->user());
    }
}