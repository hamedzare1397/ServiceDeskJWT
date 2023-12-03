<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CoefficientNews extends Pivot
{
    protected $fillable = ['news_id', 'coefficient_id', 'coefficient'];

}
