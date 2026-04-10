<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Trang chính của Admin Chat
    public function adminIndex() {
        return view('admin.chat.index'); // Bạn cần tạo file này ở Bước 4
    }

    // Lấy danh sách những khách hàng đã từng nhắn tin
    public function getChatUsers() {
        // Lấy danh sách user_id duy nhất từ bảng messages
        $userIds = Message::distinct()->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get();
        return response()->json($users);
    }

   public function getMessages($userId) {
    // Khi Admin lấy tin nhắn của User này, đánh dấu tất cả tin nhắn của User đó là đã đọc
    Message::where('user_id', $userId)
           ->where('is_from_admin', 0)
           ->update(['is_read' => 1]);

    $messages = Message::where('user_id', $userId)
                      ->orderBy('created_at', 'asc')
                      ->get();
    return response()->json($messages);
}
   public function getUnreadCount() {
    // Đếm những tin nhắn mà:
    // 1. is_from_admin = 0 (khách gửi)
    // 2. is_read = 0 (admin chưa xem)
    $count = \App\Models\Message::where('is_from_admin', 0)
                                ->where('is_read', 0)
                                ->count();
                                
    return response()->json(['unread_count' => $count]);
}
    // Gửi tin nhắn (Cả Admin và Khách dùng chung)
    public function sendMessage(Request $request) {
        $user = Auth::user();
        $isAdmin = ($user && isset($user->role) && $user->role == 'admin') ? 1 : 0;

        $message = Message::create([
            'user_id'       => $request->user_id, // ID khách hàng
            'message'       => $request->message,
            'is_from_admin' => $isAdmin,
        ]);

        return response()->json($message);
    }
    // Thêm vào ChatController.php


}