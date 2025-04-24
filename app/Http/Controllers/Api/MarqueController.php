<?php

        namespace App\Http\Controllers\Api;

        use App\Http\Controllers\Controller;
        use App\Models\Marque;
        use Illuminate\Http\Request;

        class MarqueController extends Controller
        {
            public function index()
            {
                try {
                    $marques = Marque::select('nom')->orderBy('nom')->get();
                    return response()->json($marques, 200);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'An error occurred while fetching data'], 500);
                }
            }
        }