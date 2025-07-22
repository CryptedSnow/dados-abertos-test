<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DespesaResource extends JsonResource
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
            'deputado_id'  => $this->deputados->nome,
            'tipo_despesa'  => $this->tipo_despesa,
            'valor'       => $this->valor,
            'fornecedor'       => $this->fornecedor,
            'url_documento' => $this->url_documento,
            'data_documento' => optional($this->data_documento)->format('d-m-Y'),
        ];
    }
}
