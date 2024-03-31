<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function publicBooks(): HasMany
    {
        return $this->hasMany(PublicBook::class);
    }
}
