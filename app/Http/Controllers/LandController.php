<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class LandController extends Controller
{
    // Afficher la liste des terrains
    public function index()
    {
        $lands = Land::with('images')->get();
        return response()->json($lands);
    }

    // Afficher un terrain spécifique
    public function show($id)
    {
        $land = Land::with('images')->find($id);

        if (!$land) {
            return response()->json(['error' => 'Terrain non trouvé'], 404);
        }

        return response()->json($land);
    }

    // Créer un nouveau terrain
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'area' => 'required|Double',
            'seller_id' => 'required|exists:users,id',
            'is_sold'=>'required|boolean',
        ]);

        
        $land = Land::create($request->all());

        return response()->json($land, 201);
    }

    // Mettre à jour un terrain
    public function update(Request $request, $id)
    {
        $land = Land::find($id);

        if (!$land) {
            return response()->json(['error' => 'Terrain non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string',
            'location' => 'string',
            'price' => 'numeric',
            'area' => 'numeric',
            'seller_id' => 'exists:users,id',
            'is_sold' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $land->update($request->all());

        return response()->json($land);
    }

    // Supprimer un terrain
    public function destroy($id)
    {
        $land = Land::find($id);

        if (!$land) {
            return response()->json(['error' => 'Terrain non trouvé'], 404);
        }

        $land->delete();

        return response()->json(['message' => 'Terrain supprimé']);
    }

     public function showMyLand()
    {
        $user = Auth::user();

        // Récupérer les terrains de l'utilisateur avec les photos et vidéos associées
        $land = Land::with(['images', 'videos'])
                           ->where('seller_id', $user->id)
                           ->get();

        return response()->json($land);
    }
}

