<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserRoleController extends Controller
{
    //
    public function index()
    {
//        if (!auth()->user()->is_admin) {
//            abort(403);
//        }

        $users = User::all();

        return view('users.index', ['users' => $users]);

    }

    public function destroy(User $user)
    {
        Gate::authorize('admin-access');

        if (Gate::allows('delete-users', $user)) {
            $user->delete();
            return redirect()
                ->route('user-role.index')
                ->with('success', 'Usuario borrado correctamente.');
        }

        if (Gate::allows('delete-super-admin', $user)) {
            $user->delete();
            return redirect()
                ->route('user-role.index')
                ->with('success', 'Usuario borrado correctamente.');
        }


        return redirect()
            ->route('user-role.index')
            ->with('fail', 'No puedes borrar a un Super Admin o ti mismo');
    }

    public function store(StoreUserRegister $register)
    {
        $validated = $register->validationData();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'occupation' => $validated['occupation'],
            'is_admin' => $validated['role'] === 'admin'
        ]);

        return redirect()->route('user-role.index')
            ->with('success', 'Usuario creado exitosamente.');

    }

    public function create()
    {
        return view('users.create');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);

    }

    public function update(User $user)
    {
        $validated = request()->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:254'],
            'password' => ['sometimes', 'nullable'],
            'occupation' => ['sometimes', 'string'],
            'is_admin' => ['sometimes', 'in:user,admin'],
        ]);

        // Si el password viene, lo encriptamos
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Convertir role a boolean solo si viene
        if (array_key_exists('role', $validated)) {
            $validated['is_admin'] = $validated['role'] === 'admin';
            unset($validated['role']);
        }
        $user->update(request()->all());
        return redirect()
            ->route('user-role.index')
            ->with('success', 'Actualización correcta');
    }
}
