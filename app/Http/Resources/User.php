<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'wallet' => $this->wallet
        ];
    }
    public function with($request)
    {
        return [
            'meta' => [
                'version' => '1.0.0',
                'author' => url("https://jeffreykingori.dev")
            ],
        ];
    }
}
