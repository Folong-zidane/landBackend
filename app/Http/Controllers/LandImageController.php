<?php

namespace App\Http\Controllers;

use App\Models\LandImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class LandImageController extends Controller
{
    // Afficher la liste des images de terrain
    public function index()
    {
        $landImages = LandImage::all();
        return response()->json($landImages);
    }

    // Afficher une image de terrain spécifique
    public function show($id)
    {
        $landImage = LandImage::find($id);

        if (!$landImage) {
            return response()->json(['error' => 'Image de terrain non trouvée'], 404);
        }

        return response()->json($landImage);
    }

    // Créer une nouvelle image de terrain
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'land_id' => 'required|exists:lands,id',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'caption' => 'nullable|string',
        'is_primary' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Gérer le téléchargement de l'image
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = $image->store('land_images', 'public'); // Stocker dans le dossier 'storage/app/public/land_images'
        $url = Storage::url($path); // Obtenir l'URL publique de l'image
    } else {
        return response()->json(['error' => 'Image est requise'], 422);
    }

    // Créer l'enregistrement de l'image dans la base de données
    $landImage = LandImage::create([
        'land_id' => $request->land_id,
        'url' => $url,
        'caption' => $request->caption,
        'is_primary' => $request->is_primary,
    ]);

    return response()->json($landImage, 201);
}


    // Mettre à jour une image de terrain
    public function update(Request $request, $id)
{
    $landImage = LandImage::find($id);

    if (!$landImage) {
        return response()->json(['error' => 'Image de terrain non trouvée'], 404);
    }

    $validator = Validator::make($request->all(), [
        'land_id' => 'exists:lands,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'caption' => 'nullable|string',
        'is_primary' => 'boolean',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Gérer le téléchargement de la nouvelle image, si présent
    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image du stockage
        Storage::delete(str_replace('/storage/', '', $landImage->url));

        $image = $request->file('image');
        $path = $image->store('land_images', 'public');
        $url = Storage::url($path);
        $landImage->url = $url;
    }

    // Mettre à jour les autres informations
    $landImage->land_id = $request->land_id ?? $landImage->land_id;
    $landImage->caption = $request->caption ?? $landImage->caption;
    $landImage->is_primary = $request->is_primary ?? $landImage->is_primary;
    $landImage->save();

    return response()->json($landImage);
}

public function destroy($id)
{
    $landImage = LandImage::find($id);

    if (!$landImage) {
        return response()->json(['error' => 'Image de terrain non trouvée'], 404);
    }

    // Supprimer le fichier du stockage
    Storage::delete(str_replace('/storage/', '', $landImage->url));

    $landImage->delete();

    return response()->json(['message' => 'Image de terrain supprimée']);
}

}
