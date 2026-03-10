<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class img_subasta extends Model
{
    protected $table = 'img_subastas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subasta_id',
        'url',
    ];
}
