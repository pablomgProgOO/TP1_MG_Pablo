<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'release_year' => $this->release_year,
            'length' => $this->length,
            'description' => $this->description,
            'rating' => $this->rating,
            'image' => $this->image,
            'special_features' => $this->special_features,
            'language_id' => $this->language_id,  
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,        
        ];    
    }
}
