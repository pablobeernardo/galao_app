<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = ['galao_id', 'volume', 'garrafas', 'sobra'];

    public function galao()
    {
        return $this->belongsTo(Galao::class);
    }
}
