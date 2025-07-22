<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesa extends Model
{
    use HasFactory;

    protected $table = 'despesas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'deputado_id',
        'tipo_despesa',
        'valor',
        'fornecedor',
        'url_documento',
        'data_documento'
    ];

    public function deputados(): BelongsTo
    {
        return $this->belongsTo(Deputado::class, 'deputado_id');
    }
}
