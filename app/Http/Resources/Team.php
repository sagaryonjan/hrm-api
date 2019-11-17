<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
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
            'id'           => $this->id,
            'full_name'    => $this->full_name,
            'email'        => $this->email,
            'phone_number' => $this->phone_number,
            'company'      => $this->company,
            'address'      => $this->address,
            'about'        => $this->about,
            'created_at'   => (string) $this->created_at,
        ];
    }
}
