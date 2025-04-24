<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Continent extends Model
{
    public function up()
    {
        Schema::create('continents', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
            $table->timestamps();
        });
    }
}