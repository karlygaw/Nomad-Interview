<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'contact_user' => [
                'id' => $this->contactUser->id,
                'name' => $this->contactUser->name,
                'email' => $this->contactUser->email,
                'phone' => $this->contactUser->phone,
                'address' => $this->contactUser->address,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}