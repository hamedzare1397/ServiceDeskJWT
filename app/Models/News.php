<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory,SoftDeletes;

    protected $hidden = [
        'updated_at', 'created_at','deleted_at',
    ];

    public function coefficients()
    {
        return $this->belongsToMany(Coefficient::class,'coefficient_news');
    }
}
