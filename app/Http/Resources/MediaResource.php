<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->file_name,
            'url' => $this->getUrl(),
            'thumbnail' => $this->getUrl('thumb'),
        ];
    }
}
