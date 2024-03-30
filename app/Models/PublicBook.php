<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PublicBook extends Model
{
    use HasFactory;

    protected array $fillable = [
        'title',
        'description',
        'edition',
        'publisher_id',
        'year',
        'format_id',
        'pages',
        'country_id',
        'ISBN',
    ];

    /**
     * @return BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    /**
     * @return BelongsTo
     */
    public function format(): BelongsTo
    {
        return $this->belongsTo(Format::class, 'format_id');
    }

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'public_book_authors');
    }

    /**
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'public_book_genres');
    }   
}
