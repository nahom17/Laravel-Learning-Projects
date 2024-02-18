<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileUpdateValidation;
use App\Http\Requests\UserStoreValidation;
use App\Http\Requests\UserUpdateValidation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBydesc('id')->paginate(30);

        return view('admin.users.index', compact('users'));
    }

    public function profile()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function create()
    {
        $this->authorize('isAdmin', User::class);

        return view('admin.users.create');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->paginate(30);

        return view('admin.users.index', compact('users'));
    }

    public function store(UserStoreValidation $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role_id = Role::USER;
        $user->save();

        return redirect()->route('admin.users.index')->with('message', 'Gebruiker toegevoegd');

    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $this->authorize('isAdmin', User::class);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdateValidation $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->update();

        return redirect()->route('admin.users.index')->with('message', 'Gebruiker bijgewerkt');
    }

    public function updateProfile(UserProfileUpdateValidation $request, User $user)
    {
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->address = $request->address;
        $user->zipcode = $request->zipcode;
        $user->phone_number = $request->phone_number;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/avatar/', $filename);
            $user->avatar = $filename;

            $user->email = $request->email;
            $user->update();

            return redirect()->route('profile.profile')->with('message', 'Profiel bijgewerkt');

        }
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('message', 'Gebruiker verwijdered');
    }
}
