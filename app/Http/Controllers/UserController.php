<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;



class UserController extends Controller
{
    // Afficher la liste des utilisateurs
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Afficher un utilisateur spécifique
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json($user);
    }

    // Créer un nouvel utilisateur
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15|unique:users,phone',
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user', // Assigner le rôle par défaut comme seller
        ]);

        return response()->json($user, 201);
    }


     public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15|unique:users,phone',
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'admin', // Assigner le rôle par défaut comme seller
        ]);

        return response()->json($user, 201);
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'password' => 'string|min:8|confirmed',
            'phone' => 'string|max:15|unique:users,phone',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update($request->only(['name', 'phone']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json($user);
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }



    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required_without:phone|string',
            'password' => 'required_with:name|string',
            'phone' => 'required_without:name|string',
        ]);

        // Vérification par nom d'utilisateur et mot de passe
        if ($request->has('name') && $request->has('password')) {
            $user = User::where('name', $request->name)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Connexion réussie']);
            } else {
                return response()->json(['error' => 'Identifiants invalides'], 401);
            }
        }

        // Vérification par numéro de téléphone
        if ($request->has('phone')) {
            $user = User::where('phone', $request->phone)->first();

            if ($user) {
                return response()->json(['message' => 'Numéro de téléphone trouvé, veuillez confirmer votre identité']);
            } else {
                return response()->json(['error' => 'Utilisateur non trouvé'], 404);
            }
        }

        return response()->json(['error' => 'Paramètres invalides'], 400);
    }




}
