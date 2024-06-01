<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'slug' => $this->slug,
            'stripe_id' => $this->stripe_id,
            'seo' => $this->seo,
            'body' => $this->body,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_feature' => $this->is_feature,
            'image' => config('app.url').'/storage/'.$this->image,
            'created' => $this->created_at->diffForHumans(),
            'updated' => $this->updated_at->diffForHumans(),
            'category' => $this->category
        ];
    }
}
