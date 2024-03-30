<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['country_name'];

    /**
     * @return HasMany
     */
    public function publicBooks(): HasMany
    {
        return $this->hasMany(PublicBook::class);
    }
}
