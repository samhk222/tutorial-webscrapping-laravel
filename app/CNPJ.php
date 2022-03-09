<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CNPJ extends Model
{
    protected $table = 'cnpjs';

    protected $fillable = ['cnpj, status'];

    public $timestamps = false;
}
