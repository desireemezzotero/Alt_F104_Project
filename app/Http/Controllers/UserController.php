<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /* TUTTI GLI UTENTI */
    public function index()
    {
        if (auth()->user()->role !== 'Admin/PI') {
            abort(403, 'Accesso negato.');
        }

        $users = User::orderBy('name')->get();

        return view('userGlobalAdmin', compact('users'));
    }

    /* CREARE UN NUOVO UTENTE */
    public function create()
    {
        if (auth()->user()->role !== 'Admin/PI') abort(403);
        return view('userCreate');
    }

    /* SALVARE IL NUOVO UTENTE */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'Admin/PI') abort(403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'string'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('user.index')->with('success', 'Utente creato con successo!');
    }


    /* ELIMINARE UTENTE */
    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'Admin/PI') abort(403);
        $user->projects()->detach();

        $user->tasks()->update(['user_id' => null]);

        $user->comments()->delete();

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Pubblicazione eliminata.');
    }
}
