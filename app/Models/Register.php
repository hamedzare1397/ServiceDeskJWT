<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function news()
    {
        return $this->belongsTo(News::class);
    }
    public function coefficient()
    {
        return $this->belongsTo(Coefficient::class);
    }
}
