<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class messagesController extends Controller
{
    /**
     * Display the messages interface with conversations
     */
    public function messages()
    {
        $user = Auth::user();
        
        // Get all conversations (unique users the current user has messaged with)
        $conversations = $this->getConversations($user);
        
        // Get unread message count
        $unreadCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        return view('files.messages', compact('conversations', 'unreadCount'));
    }

    /**
     * Get conversation with a specific user
     */
    public function getConversation(Request $request, $userId)
    {
        $user = Auth::user();
        $otherUser = User::findOrFail($userId);
        
        // Get messages between current user and the other user
        $messages = Message::where(function($query) use ($user, $userId) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function($query) use ($user, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver', 'job'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark messages from the other user as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        return response()->json([
            'messages' => $messages,
            'other_user' => $otherUser,
            'current_user' => $user,
            'conversation_exists' => $messages->count() > 0
        ]);
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'job_id' => 'nullable|exists:jobs,id'
        ]);

        $user = Auth::user();
        
        // Prevent sending message to self
        if ($request->receiver_id == $user->id) {
            return response()->json(['error' => 'Cannot send message to yourself'], 400);
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'job_id' => $request->job_id,
            'is_read' => false
        ]);

        $message->load(['sender', 'receiver', 'job']);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Get all users available for messaging (excluding current user)
     */
    public function getAvailableUsers()
    {
        $user = Auth::user();
        
        // Get users based on role - workers can message employers and vice versa
        $query = User::where('id', '!=', $user->id);
        
        if ($user->isWorker()) {
            // Workers can message employers and admins
            $query->whereIn('role', ['employer', 'admin']);
        } elseif ($user->isEmployer()) {
            // Employers can message workers and admins
            $query->whereIn('role', ['worker', 'admin']);
        } else {
            // Admins can message everyone
            $query->whereIn('role', ['worker', 'employer']);
        }
        
        $users = $query->select('id', 'name', 'email', 'role', 'profile_picture')
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    /**
     * Search users for messaging
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('search', '');
        $user = Auth::user();
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $query = User::where('id', '!=', $user->id)
            ->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });

        if ($user->isWorker()) {
            $query->whereIn('role', ['employer', 'admin']);
        } elseif ($user->isEmployer()) {
            $query->whereIn('role', ['worker', 'admin']);
        }

        $users = $query->select('id', 'name', 'email', 'role', 'profile_picture')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $count = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Mark conversation as read
     */
    public function markConversationAsRead($userId)
    {
        $user = Auth::user();
        
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a message
     */
    public function deleteMessage($messageId)
    {
        $user = Auth::user();
        $message = Message::where('id', $messageId)
            ->where('sender_id', $user->id)
            ->firstOrFail();

        $message->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get conversations for the current user
     */
    private function getConversations($user)
    {
        // Get unique users that have conversations with current user
        $conversationUsers = DB::table('messages')
            ->select(
                DB::raw('CASE 
                    WHEN sender_id = ' . $user->id . ' THEN receiver_id 
                    ELSE sender_id 
                END as user_id'),
                DB::raw('MAX(created_at) as last_message_time'),
                DB::raw('COUNT(CASE WHEN receiver_id = ' . $user->id . ' AND is_read = 0 THEN 1 END) as unread_count')
            )
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->groupBy('user_id')
            ->orderBy('last_message_time', 'desc')
            ->get();

        // Get user details and last messages
        $conversations = [];
        foreach ($conversationUsers as $conv) {
            $otherUser = User::find($conv->user_id);
            if ($otherUser) {
                $lastMessage = Message::where(function($query) use ($user, $conv) {
                        $query->where('sender_id', $user->id)
                              ->where('receiver_id', $conv->user_id);
                    })
                    ->orWhere(function($query) use ($user, $conv) {
                        $query->where('sender_id', $conv->user_id)
                              ->where('receiver_id', $user->id);
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();

                $conversations[] = [
                    'user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $conv->unread_count,
                    'last_message_time' => $conv->last_message_time
                ];
            }
        }

        return $conversations;
    }
}
