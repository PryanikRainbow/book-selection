<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->resource->id,
            'title'        => $this->resource->title,
            'year'         => date('Y', strtotime($this->resource->release_date)),
            'authors'      => $this->resource->authors->pluck('name')->toArray(),
            'publisher'    => $this->publisher?->name,
        ];
    }
}
