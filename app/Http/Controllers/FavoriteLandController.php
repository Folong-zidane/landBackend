<?php

namespace App\Http\Controllers;

use App\Models\FavoriteLand;
use Illuminate\Http\Request;

class FavoriteLandController extends Controller
{
    public function store(Request $request)
    {
        $favorite = FavoriteLand::create([
            'user_id' => $request->user()->id,
            'land_id' => $request->land_id,
        ]);

        return response()->json(['message' => 'Terrain ajouté aux favoris', 'favorite' => $favorite]);
    }

    public function destroy($id)
    {
        $favorite = FavoriteLand::where('user_id', auth()->id())->where('land_id', $id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Terrain retiré des favoris']);
        }

        return response()->json(['error' => 'Terrain non trouvé'], 404);
    }
}
