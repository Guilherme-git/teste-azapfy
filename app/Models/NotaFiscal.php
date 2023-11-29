<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    use HasFactory;
    protected $table = "notafiscal";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $hidden = [
        'id_usuario'
    ];

    public function usuario() {
        return $this->hasOne(User::class,'id','id_usuario');
    }

}
