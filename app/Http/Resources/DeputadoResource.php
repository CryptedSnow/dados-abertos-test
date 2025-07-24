<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeputadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'camara_id'  => $this->camara_id,
            'nome'       => $this->nome,
            'partido'    => $this->partido,
            'uf'         => $this->uf,
        ];
    }
}
