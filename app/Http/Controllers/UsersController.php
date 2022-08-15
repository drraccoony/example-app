<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return abort(403);
        }

        $user = user::query()
            ->get();

        return view('users.index')
            ->with(compact('user'));
    }

    public function edit(Request $request, User $user)
    {
        if ($request->user()->cannot('update', $user)) {
            return redirect()->route('user.edit', [$request->user->id]);
        }

        return view('users.edit')
            ->with(compact('user'));
    }

    public function confirm(Request $request, User $user)
    {
        if (
            ($request->user()->id === $user->id)
            || $request->user()->cannot('delete', $user)
        ) {
            return redirect()->route('users');
        }

        return view('users.confirm')
            ->with(compact('user'));
    }

    public function delete(Request $request, User $user)
    {
        // Admins can't delete their own account
        if (
            !($request->user()->id === $user->id)
            && $request->user()->can('delete', User::class)
        ) {
            $user->delete();
        }

        return redirect()->route('users');
    }
}
