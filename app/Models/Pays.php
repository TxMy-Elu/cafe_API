<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;

    protected $table = 'pays';

    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }

    public function dosettes()
    {
        return $this->hasMany(Dosette::class);
    }
}
