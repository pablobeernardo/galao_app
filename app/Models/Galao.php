<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galao extends Model
{
    use HasFactory;

    protected $fillable = ['volume'];

    public function garrafas()
    {
        return $this->hasMany(Garrafa::class);
    }
}
