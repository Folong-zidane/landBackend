<?php


namespace App\Http\Controllers;

use App\Models\LandVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class LandVideoController extends Controller
{
    // Afficher la liste des vidéos de terrain
    public function index()
    {
        $landVideos = LandVideo::all();
        return response()->json($landVideos);
    }

    // Afficher une vidéo de terrain spécifique
    public function show($id)
    {
        $landVideo = LandVideo::find($id);

        if (!$landVideo) {
            return response()->json(['error' => 'Vidéo de terrain non trouvée'], 404);
        }

        return response()->json($landVideo);
    }

    // Créer une nouvelle vidéo de terrain
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'land_id' => 'required|exists:lands,id',
            'video' => 'required|mimes:mp4,avi,mov|max:10000', // Ajustez les types et la taille si nécessaire
            'caption' => 'nullable|string',
            'is_primary' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Gérer le téléchargement de la vidéo
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $path = $video->store('land_videos', 'public'); // Stocker dans le dossier 'storage/app/public/land_videos'
            $url = Storage::url($path); // Obtenir l'URL publique de la vidéo
        } else {
            return response()->json(['error' => 'Vidéo est requise'], 422);
        }

        // Créer l'enregistrement de la vidéo dans la base de données
        $landVideo = LandVideo::create([
            'land_id' => $request->land_id,
            'url' => $url,
            'caption' => $request->caption,
            'is_primary' => $request->is_primary,
        ]);

        return response()->json($landVideo, 201);
    }

    // Mettre à jour une vidéo de terrain
    public function update(Request $request, $id)
    {
        $landVideo = LandVideo::find($id);

        if (!$landVideo) {
            return response()->json(['error' => 'Vidéo de terrain non trouvée'], 404);
        }

        $validator = Validator::make($request->all(), [
            'land_id' => 'exists:lands,id',
            'video' => 'nullable|mimes:mp4,avi,mov|max:10000',
            'caption' => 'nullable|string',
            'is_primary' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Gérer le téléchargement de la nouvelle vidéo, si présente
        if ($request->hasFile('video')) {
            // Supprimer l'ancienne vidéo du stockage
            Storage::delete(str_replace('/storage/', '', $landVideo->url));

            $video = $request->file('video');
            $path = $video->store('land_videos', 'public');
            $url = Storage::url($path);
            $landVideo->url = $url;
        }

        // Mettre à jour les autres informations
        $landVideo->land_id = $request->land_id ?? $landVideo->land_id;
        $landVideo->caption = $request->caption ?? $landVideo->caption;
        $landVideo->is_primary = $request->is_primary ?? $landVideo->is_primary;
        $landVideo->save();

        return response()->json($landVideo);
    }

    // Supprimer une vidéo de terrain
    public function destroy($id)
    {
        $landVideo = LandVideo::find($id);

        if (!$landVideo) {
            return response()->json(['error' => 'Vidéo de terrain non trouvée'], 404);
        }

        // Supprimer la vidéo du stockage
        Storage::delete(str_replace('/storage/', '', $landVideo->url));

        $landVideo->delete();

        return response()->json(['message' => 'Vidéo de terrain supprimée']);
    }
}
