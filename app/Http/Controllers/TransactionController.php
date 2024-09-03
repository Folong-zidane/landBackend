<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    // Afficher la liste des transactions
    public function index()
    {
        $transactions = Transaction::with(['land', 'buyer', 'seller'])->get();
        return response()->json($transactions);
    }

    // Afficher une transaction spécifique
    public function show($id)
    {
        $transaction = Transaction::with(['land', 'buyer', 'seller'])->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction non trouvée'], 404);
        }

        return response()->json($transaction);
    }

    // Créer une nouvelle transaction
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'land_id' => 'required|exists:lands,id',
            'buyer_id' => 'required|exists:users,id',
            'seller_id' => 'required|exists:users,id',
            'price' => 'required|numeric',
            'status' => 'required|boolean',
            'transaction_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction = Transaction::create($request->all());

        return response()->json($transaction, 201);
    }

    // Mettre à jour une transaction
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction non trouvée'], 404);
        }

        $validator = Validator::make($request->all(), [
            'land_id' => 'exists:lands,id',
            'buyer_id' => 'exists:users,id',
            'seller_id' => 'exists:users,id',
            'price' => 'numeric',
            'status' => 'boolean',
            'transaction_date' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction->update($request->all());

        return response()->json($transaction);
    }

    // Supprimer une transaction
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction non trouvée'], 404);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction supprimée']);
    }
}

