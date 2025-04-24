<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dosette;
use App\Models\Marque;
use App\Models\Pays;
use Illuminate\Http\Request;

class DosetteController extends Controller
{
    public function index(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'ordre' => 'sometimes|string',
            'tri' => 'sometimes|string|in:ASC,DESC',
            'prixMin' => 'sometimes|numeric',
            'prixMax' => 'sometimes|numeric',
            'intensiteMin' => 'sometimes|integer',
            'intensiteMax' => 'sometimes|integer',
            'pays' => 'sometimes|string',
            'continent' => 'sometimes|string',
            'marque' => 'sometimes|string',
        ]);

        try {
            $query = Dosette::query();

            $query->join('marques', 'dosette.id_marques', '=', 'marques.id')
                ->join('pays', 'dosette.id_pays', '=', 'pays.id')
                ->join('continents', 'pays.id_continents', '=', 'continents.id')
                ->select('dosette.id', 'dosette.nom', 'dosette.intensite', 'dosette.prix', 'marques.nom as marque_nom', 'pays.nom as pays_nom', 'continents.nom as continent_nom');

            if ($request->has('ordre')) {
                $query->orderBy($request->ordre, $request->tri ?? 'ASC');
            } else {
                $query->orderBy('id');
            }

            if ($request->has('prixMin')) {
                $query->where('prix', '>=', $request->prixMin);
            }

            if ($request->has('prixMax')) {
                $query->where('prix', '<=', $request->prixMax);
            }

            if ($request->has('intensiteMin')) {
                $query->where('intensite', '>=', $request->intensiteMin);
            }

            if ($request->has('intensiteMax')) {
                $query->where('intensite', '<=', $request->intensiteMax);
            }

            if ($request->has('pays')) {
                $query->where('pays.nom', $request->pays);
            }

            if ($request->has('continent')) {
                $query->where('continents.nom', $request->continent);
            }

            if ($request->has('marque')) {
                $query->where('marques.nom', $request->marque);
            }

            $dosettes = $query->get();
            return response()->json($dosettes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve dosettes'], 500);
        }
    }


    public function show($id)
    {
        try {
            $dosette = Dosette::findOrFail($id);
            return response()->json($dosette, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => "L'ID n'existe plus"], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve dosette'], 500);
        }
    }

  public function store(Request $request)
  {
      $request->validate([
          'nom' => 'sometimes|required|string|max:100',
          'intensite' => 'sometimes|required|integer',
          'prix' => 'sometimes|required|numeric',
          'marque_nom' => 'sometimes|required|string',
          'pays_nom' => 'sometimes|required|string',
      ]);

      try {
          // Find the Marque by name
          $marque = Marque::where('nom', $request->marque_nom)->firstOrFail();
          // Find the Pays by name
          $pays = Pays::where('nom', $request->pays_nom)->firstOrFail();

          // Merge the IDs into the request data
          $request->merge([
              'id_marques' => $marque->id,
              'id_pays' => $pays->id,
          ]);

          // Remove marque_nom and pays_nom from the request data
          $data = $request->except(['marque_nom', 'pays_nom']);

          // Create the Dosette with the modified data
          $dosette = Dosette::create($data);
          return response()->json($dosette, 201);
      } catch (\Exception $e) {
          return response()->json(['error' => 'Failed to create dosette'], 500);
      }
  }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'sometimes|required|string|max:100',
            'intensite' => 'sometimes|required|integer',
            'prix' => 'sometimes|required|numeric',
            'marque_nom' => 'sometimes|required|string',
            'pays_nom' => 'sometimes|required|string',
        ]);

        try {
            $dosette = Dosette::findOrFail($id);

            if ($request->has('marque_nom')) {
                $marque = Marque::where('nom', $request->marque_nom)->firstOrFail();
                $request->merge(['id_marques' => $marque->id]);
            }

            if ($request->has('pays_nom')) {
                $pays = Pays::where('nom', $request->pays_nom)->firstOrFail();
                $request->merge(['id_pays' => $pays->id]);
            }

            $dosette->update($request->all());
            return response()->json($dosette, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => "L'ID n'existe plus"], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update dosette'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $dosette = Dosette::findOrFail($id);
            $dosette->delete();
            return response()->json(null, 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => "L'ID n'existe plus"], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete dosette'], 500);
        }
    }
}
