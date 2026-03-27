<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recommendation;

class AdminController extends Controller
{
    public function stats()
    {
        // total
        $totalPlates = Plat::count();
        $totalCategories = Category::count();
        $totalIngredients = Ingredient::count();
        $totalRecommendations = Recommendation::count();

       
        $mostRecommended = Recommendation::selectRaw('plate_id, AVG(score) as avg_score')
            ->groupBy('plate_id')
            ->orderByDesc('avg_score')
            ->first();

        $leastRecommended = Recommendation::selectRaw('plate_id, AVG(score) as avg_score')
            ->groupBy('plate_id')
            ->orderBy('avg_score')
            ->first();

        
        $topCategory = Category::withCount('plats')
            ->orderByDesc('plats_count')
            ->first();

        return response()->json([
            'total_plates' => $totalPlates,
            'total_categories' => $totalCategories,
            'total_ingredients' => $totalIngredients,
            'total_recommendations' => $totalRecommendations,
            'most_recommended_plate' => $mostRecommended,
            'least_recommended_plate' => $leastRecommended,
            'top_category' => $topCategory
        ]);
    }
}