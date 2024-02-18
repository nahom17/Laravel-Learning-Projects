<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Project_User;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class Projects_UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user, Project $project)
    {
        $projectUsers = Project_User::where('project_id', $project->id)->get();
        $users = User::orderBy('name')->get();
        foreach ($projectUsers as $projectUser) {
            $users = $users->where('id', '!=', $projectUser->user_id);
        }
        $roles = Role::all();

        return view('admin.projects.user.create', compact('users', 'project', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $projectUser = new Project_User();
        $projectUser->user_id = $request->user_id;
        $projectUser->project_id = $project->id;
        $projectUser->role_id = $request->role_id;
        $projectUser->save();

        return redirect()->route('admin.projects.users.indexUser', $project)->with('message', 'Gebruiker is toegevoegd');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Project_User $user)
    {
        $roles = Role::all();

        return view('admin.projects.user.editRole', compact('project', 'user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Project_User $user)
    {
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('admin.projects.users.indexUser', $project)->with('message', 'Gebruiker rol is bijwerkt');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Project_User $user)
    {
        $this->authorize('isAdmin', User::class);
        $user->delete();

        return redirect()->route('admin.projects.users.indexUser', $project)->with('message', 'Gebruiker is verwijdered');

    }
}
