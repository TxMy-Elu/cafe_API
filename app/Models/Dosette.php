<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosette extends Model
{
    use HasFactory;

    protected $table = 'dosette';

    protected $fillable = ['nom', 'intensite', 'prix', 'id_marques', 'id_pays'];

    public $timestamps = false;

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }
}