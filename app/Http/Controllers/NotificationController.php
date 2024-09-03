<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;
        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->where('id', $id)->first();

        if ($notification) {
            $notification->update(['read_at' => now()]);
            return response()->json(['message' => 'Notification marquée comme lue']);
        }

        return response()->json(['error' => 'Notification non trouvée'], 404);
    }
}
