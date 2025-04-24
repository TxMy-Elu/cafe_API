<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Continent;
    use Illuminate\Http\Request;

    class ContinentController extends Controller
    {
        public function index()
        {
            try {
                $continents = Continent::orderBy('nom')->get();
                return response()->json($continents, 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching data'], 500);
            }
        }
    }