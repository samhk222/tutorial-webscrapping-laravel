<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{
    protected $table = 'configs';

    protected $fillable = ['start', 'step', 'increment'];

    protected $casts = [
        'start' => 'integer',
        'step' => 'integer',
        'increment' => 'integer',
    ];
    public $timestamps = false;

    /*================================================================================================================*/
    /*==================== GETS ======================================================================================*/
    /*================================================================================================================*/

    public function getStartShowAttribute()
    {
        return sprintf("<strong>%s</strong>", \number_format($this->start, 0, ',', '.'));
    }

}
