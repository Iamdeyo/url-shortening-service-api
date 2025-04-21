<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortUrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            "id" => $this->id,
            "url" => $this->url,
            "shortCode" => $this->short_code,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];

        // Add accessCount only on the /stats route
        if ($request->is('api/shorten/*/stats')) {
            $data['accessCount'] = $this->access_count;
        }

        return $data;
    }
}
