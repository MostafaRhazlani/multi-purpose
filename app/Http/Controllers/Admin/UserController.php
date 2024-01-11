<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {


        $users = User::query()
        ->when(request('query'), function ($query, $searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%");
        })
        ->latest()
        ->paginate(setting('pagination_limit'));

        return $users;
    }

    public function store() {

        request()->validate([
            'email' => 'required|unique:users,email',
        ]);

        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
    }

    public function update(User $user) {

        request()->validate([
            'email' => 'required|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        return $user;
    }

    public function destroy(User $user) {
        $user->delete();

        return response()->noContent();
    }

    public function changeRole(User $user) {
        $user->update([
            'role' => request('role')
        ]);

        return response()->json(['success' => true]);
    }

    public function bulkDelete() {

        User::whereIn('id', request('ids'))->delete();

        return response()->json(['message' => 'Users deleted successfully']);
    }
}
