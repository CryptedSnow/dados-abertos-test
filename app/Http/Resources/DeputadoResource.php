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
            'camera_id'  => $this->camera_id,
            'nome'       => $this->nome,
            'partido'      => $this->partido,
            'uf'       => $this->uf,
            'created_at' => optional($this->created_at)->timezone('America/Sao_Paulo')->format('d-m-Y H:i:s'),
            'updated_at' => optional($this->updated_at)->timezone('America/Sao_Paulo')->format('d-m-Y H:i:s'),
        ];
    }
}
