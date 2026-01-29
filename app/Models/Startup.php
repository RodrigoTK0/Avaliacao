<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Startup extends Model
{
    use HasFactory;

    // Campos que permitimos preencher via formulário
    protected $fillable = [
        'nome',
        'setor',
        'email_contato',
        'data_cadastro'
    ];
    
    protected $casts = [
    'data_cadastro' => 'datetime',
    ];
}
