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
            'category' => $this->whenLoaded('category', fn() => new CategoryResource($this->category)),
            'user' => $this->whenLoaded('user', fn() => new UserSummaryResource($this->user)),
            'title' => $this->title,
            'description' => $this->description,
            'article_photo_path' => $this->article_photo_path,
            'views_count' => $this->views_count,
        ];
    }
}
