<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $users = User::latest()->get();

        return $users;
    }

    public function store() {

        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('name')),
        ]);
    }
}
