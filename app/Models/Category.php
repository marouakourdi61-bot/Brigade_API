<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'user_id'];

    // Relation avec les plats
    public function plats()
    {
        return $this->hasMany(Plat::class);
    }

    //relation user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
