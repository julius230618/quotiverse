<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['category_name'];

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
