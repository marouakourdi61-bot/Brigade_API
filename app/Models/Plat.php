<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Plat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'category_id',
        'user_id',
    ];

    // Relation avec catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Plat  Ingredients (pivot)
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_plate');
    }

    // Plat  Recommendations
    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }
}
