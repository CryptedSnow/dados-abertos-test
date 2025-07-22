<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    use HasFactory;

    protected $table = 'deputados';
    protected $primaryKey = 'id';
    protected $fillable = [
       'camara_id',
       'nome',
       'partido',
       'uf'
    ];

}
