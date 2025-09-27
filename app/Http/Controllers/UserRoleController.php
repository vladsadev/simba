<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRegister;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    //
    public function index()
    {

        $users = User::all();

        return view('users.index', ['users' => $users]);

    }

    public function destroy(User $user)
    {

        $user->delete();
        return redirect(route('user-role.index'))
            ->with('success', 'El usuario fue borrado correctamente');


    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRegister $register)
    {
        dd($register->all());
    }

    public function edit(User $user)
    {

        return view('users.edit', ['user' => $user]);

    }

    public function update(User $user)
    {
        return 'ok Choco';
    }
}
