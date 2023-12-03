<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coefficient extends Model
{
    use HasFactory;

    protected $hidden = [
        'updated_at', 'created_at','deleted_at',
    ];

    public function news()
    {
        return $this->belongsToMany(News::class,'coefficient_news')
            ->withPivot('coefficient');
    }
}
