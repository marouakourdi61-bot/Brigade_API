<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Models\Plat;
use Illuminate\Support\Facades\Auth;
use App\Jobs\AnalyzeRecommendationJob;

class RecommendationController extends Controller
{
    public function analyze($plate_id)
    {
        $user = Auth::user();

        $plate = Plat::find($plate_id);
        if (!$plate) {
            return response()->json([
                'message' => 'Plate not found'
            ], 404);
        }

        $existing = Recommendation::where('user_id', $user->id)
            ->where('plate_id', $plate_id)
            ->first();

        if ($existing && $existing->status === 'processing') {
            return response()->json([
                'status' => 'processing'
            ], 202);
        }

        $recommendation = Recommendation::updateOrCreate(
            [
                'user_id' => $user->id,
                'plate_id' => $plate_id
            ],
            [
                'status' => 'processing'
            ]
        );

        
        AnalyzeRecommendationJob::dispatch($recommendation->id);

        return response()->json([
            'status' => 'processing'
        ], 202);
    }

    // GET all
    public function index()
    {
        return Auth::user()->recommendations()
            ->with('plat')
            ->get();
    }

    // GET one
    public function show($plate_id)
    {
        $rec = Recommendation::where('user_id', Auth::id())
            ->where('plate_id', $plate_id)
            ->first();

        if (!$rec) {
            return response()->json([
                'message' => 'Recommendation not found'
            ], 404);
        }

        if ($rec->status === 'processing') {
            return response()->json([
                'status' => 'processing'
            ], 202);
        }

        return response()->json($rec);
    }
}