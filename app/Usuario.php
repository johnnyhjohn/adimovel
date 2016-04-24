<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Usuario extends User
{
    
    protected $fillable = [
        'nome', 'email', 'senha', 'cpf','admin','status','tipo_funcionario',
    ];


    protected $hidden = [
        'senha', 'remember_token',
    ];
}
