<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ArchiveUserRequest;
use App\Http\Requests\User\RestoreUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateStaffPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()
            ->where('role', User::ROLE_STAFF)
            ->filter($request->only(['search', 'status']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->staffData());

        return redirect()
            ->route('users.index')
            ->with('message', 'Staff user created successfully.');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    public function updatePassword(UpdateStaffPasswordRequest $request, User $user)
    {
        $user->update($request->safe()->only('password'));

        return redirect()
            ->route('users.show', $user)
            ->with('message', 'Staff password updated successfully.');
    }

    public function archive(ArchiveUserRequest $request, User $user)
    {
        if (! $user->isArchived()) {
            $user->archive();
        }

        return redirect()
            ->route('users.show', $user)
            ->with('message', 'Staff user archived successfully.');
    }

    public function restore(RestoreUserRequest $request, User $user)
    {
        if ($user->isArchived()) {
            $user->restoreFromArchive();
        }

        return redirect()
            ->route('users.show', $user)
            ->with('message', 'Staff user restored successfully.');
    }
}
