<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Get all users
    public function getUsers()
    {
        $users = User::with('role')->orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }

    // Update user role
    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['message' => 'User role updated successfully', 'user' => $user->load('role')]);
    }

    // Delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'You cannot delete yourself'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    // Get dashboard statistics
    public function getStats()
    {
        $totalUsers = User::count();
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalRevenue = \App\Models\Order::sum('total');

        return response()->json([
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalRevenue' => $totalRevenue,
        ]);
    }
}
