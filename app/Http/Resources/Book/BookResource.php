<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'        => $this->resource->title,
            'description'  => $this->resource->description,
            'authors'      => $this->resource->authors->pluck('name')->toArray(),
            'genres'       => $this->resource->genres->pluck('name')->toArray(),
            'edition'      => $this->resource->edition,
            'release_date' => $this->release_date?->format('Y-m-d'),
            'publisher'    => $this->publisher->name,
            'format'       => $this->format->name,
            'pages'        => $this->pages,
            'country'      => $this->country->name,
            'ISBN'         => $this->ISBN,
        ];
    }
}
