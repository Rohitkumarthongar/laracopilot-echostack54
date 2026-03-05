<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Notification::findOrFail($id)->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Notification::where('is_read', false)->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function count()
    {
        $count = Notification::where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }
}