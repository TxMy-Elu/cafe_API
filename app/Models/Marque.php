<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    use HasFactory;

    protected $table = 'marques';

    public function dosettes()
    {
        return $this->hasMany(Dosette::class);
    }
}
