<?php

namespace App\Models;

use App\Models\ViewModels\ValueModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    public function registers():HasMany
    {
        return $this->hasMany(Register::class);
    }

    public function registerVal():HasMany
    {
        return $this->hasMany(ValueModel::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function news()
    {
        $this->hasMany(News::class,Register::class);
    }
}
