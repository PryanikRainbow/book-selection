<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Format extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
