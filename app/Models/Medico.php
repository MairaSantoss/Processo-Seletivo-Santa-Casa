<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'CRM',
        'telefone',
        'email',
        'dt_cadastro'
    ];
    public $timestamps = false;

    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class);
    }
}





