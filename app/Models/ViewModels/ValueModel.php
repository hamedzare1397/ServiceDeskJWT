<?php

namespace App\Models\ViewModels;

use App\Models\News;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValueModel extends Model
{
    protected $table = 'registervalues';

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
