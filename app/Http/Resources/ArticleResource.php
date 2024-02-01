<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'slug' => $this->slug,
            'body' => $this->body,
            'excerpt' => $this->excerpt,
            'image_path' => $this->image_path,
            'clapsCount' => $this->clapsCount,
            'created_at' => $this->created_at,
            'user' => UserResource::make($this->user),
            'tags' => $this->tags,
        ];
    }
}
