<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use Illuminate\Http\Request;

class PaysController extends Controller
{
   public function index()
    {
        try {
            $pays = Pays::select('pays.nom', 'continents.nom as continent')
                ->join('continents', 'pays.id_continents', '=', 'continents.id')
                ->orderBy('pays.nom')
                ->get();

            return response()->json($pays, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data'], 500);
        }
    }
}