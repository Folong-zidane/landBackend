<?php

namespace App\Http\Controllers;

use App\Models\AdminAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminActionControllers extends Controller
{
    // Afficher la liste des actions des administrateurs
    public function index()
    {
        $adminActions = AdminAction::with('admin')->get();
        return response()->json($adminActions);
    }

    // Afficher une action spécifique
    public function show($id)
    {
        $adminAction = AdminAction::with('admin')->find($id);

        if (!$adminAction) {
            return response()->json(['error' => 'Action d\'administrateur non trouvée'], 404);
        }

        return response()->json($adminAction);
    }

    // Créer une nouvelle action d'administrateur
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|exists:users,id',
            'action' => 'required|string',
            'description' => 'nullable|string',
            'action_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $adminAction = AdminAction::create($request->all());

        return response()->json($adminAction, 201);
    }

    // Mettre à jour une action d'administrateur
    public function update(Request $request, $id)
    {
        $adminAction = AdminAction::find($id);

        if (!$adminAction) {
            return response()->json(['error' => 'Action d\'administrateur non trouvée'], 404);
        }

        $validator = Validator::make($request->all(), [
            'admin_id' => 'exists:users,id',
            'action' => 'string',
            'description' => 'nullable|string',
            'action_date' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $adminAction->update($request->all());

        return response()->json($adminAction);
    }

    // Supprimer une action d'administrateur
    public function destroy($id)
    {
        $adminAction = AdminAction::find($id);

        if (!$adminAction) {
            return response()->json(['error' => 'Action d\'administrateur non trouvée'], 404);
        }

        $adminAction->delete();

        return response()->json(['message' => 'Action d\'administrateur supprimée']);
    }
}
