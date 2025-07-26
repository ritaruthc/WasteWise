<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class NotificationController extends Controller
{

    public function index()
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user(); 

        // Ambil semua notifikasi milik user tersebut dengan query builder
        $notifications = DB::table('notifications')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->paginate(10);

        // Hitung jumlah notifikasi yang belum dibaca
        $unreadNotifications = DB::table('notifications')
                                ->where('user_id', $user->id)
                                ->where('is_read', false)
                                ->count();

        return view('notifications.index', compact('notifications', 'unreadNotifications'));
    }


    public function markAsRead(Notification $notification)
    {
        // Pastikan pengguna hanya bisa menandai notifikasi miliknya sendiri
        if ($notification->user_id == auth()->id()) {
            $notification->is_read = true;
            $notification->save();
        }

        return redirect()->route('notifications.index')->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    public function destroy(Notification $notification)
    {
        // Pastikan pengguna hanya bisa menghapus notifikasi miliknya sendiri
        if ($notification->user_id == auth()->id()) {
            $notification->delete();
        }

        return redirect()->route('notifications.index')->with('success', 'Notifikasi telah dihapus.');
    }

    // tanda baca semua notifikasi
    public function someFunction()
    {
        $unreadNotifications = Auth::user()->unreadNotifications->count();
        return view('someview', compact('unreadNotifications'));
    }


}
