<?php

namespace App\Http\Controllers\Admin;

use Projects;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreValidation;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProjectStoreValidation;
use App\Http\Requests\TaskStoreValidation;
use App\Models\Company;
use App\Models\Project_User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {

        $projects= Project::orderBydesc('id')->paginate(3);
        return view('admin.projects.index',compact('projects'));
    }

    public function userIndex(Project $project)
    {
        $users = User::all();
        $task = Task::where('project_id', $project->id)->orderBy('created_at', 'DESC')->paginate(20);
        return view('admin.projects.user.index', compact('project', 'users','task'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $projects = Project::query()
        ->where('title', 'LIKE', "%" . $search . "%")
        ->paginate(30);
        return view('admin.projects.index',compact('projects'));
    }



    public function create()
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.projects.create');
    }


    public function store(ProjectStoreValidation $request)
    {
        $project = new Project;
        $project->title = $request->title;
        $project->intro = $request->intro;
        $project->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/project/', $filename);
            $project->image = $filename;
        }

        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->company_id = $request->company_id;
        $project->save();

        return redirect()->route('admin.projects.index')->with('message', 'Project toegevoged');

    }

    public function show(Project $project)
    {
        return view('projects.show',compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.projects.edit',compact('project'));
    }

    public function update(ProjectStoreValidation $request , Project $project)
    {
        $project->title = $request->title;
        $project->intro = $request->intro;
        $project->description = $request->description;

        if ($request->hasFile('image')) {
            $destination = 'uploads/project/' . $project->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/article/', $filename);
            $project->image = $filename;
        }

        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->company_id = $request->company_id;

        $project->update();
        return redirect()->route('admin.projects.index')->with('message', 'Projects bijgewerkt');
    }

    public function destroy(Project $project)
    {
        if($project) {
        $destination = 'uploads/project/' . $project->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $project->delete();
            return redirect()->route('admin.projects.index')->with('message', 'Project verwijdered');

        } else{
            return redirect()->route('admin.projects.index')->with('message', 'Geen article gevonden');
        }
    }

// start functions for tasks by project
    public function indexTask(Project $project, User $user)
    {
        $this->authorize('isAdmin', User::class);
        $user = Auth::user();
        $tasks = Task::where('project_id', $project->id)->orderBydesc('created_at')->paginate(20);
        return view('admin.projects.task.index', compact('tasks', 'user'))->with('project', $project);
    }

    public function createTask(User $user, Project $project)
    {
        $this->authorize('isAdmin', User::class);
        $users = Task::where('user_id', $user->id)->get();
        return view('admin.projects.task.create', compact('users', 'project'));

    }
    public function storeTask(TaskStoreValidation $request, Project $project, User $user)
    {
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->project_id = $project->id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->completed = 0;
        $task->save();
        return redirect()->route('admin.projects.tasks.indexTask',$project)->with('message', 'Taak toegevoegd');
    }
    public function editTask(Project $project, Task $task , User $users)
    {
        return view('admin.projects.task.edit' , compact('task','project','users'));
    }

    public function updateTask(TaskStoreValidation $request, Project $project, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->project_id = $project->id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->save();
        return redirect()->route('admin.projects.tasks.indexTask',$project)->with('message', 'Taak bijgewerkt');
    }
    public function destroyTask(Project $project, Task $task)
    {
        $task->delete();
        return redirect()->route('admin.projects.tasks.indexTask',$project)->with('message', 'Taak verwijdered');
    }
//end functions for tasks by project



//start functions for company by project
    public function indexCompany(Project $project)
    {
        return view('admin.projects.company.index',compact('project'));
    }
    public function editCompany(Project $project,Company $company )
    {
        return view('admin.projects.company.edit',compact('project','company'));
    }
    public function updateCompany(CompanyStoreValidation $request,Project $project, Company $company)
    {
        $project->company->name = $request->name;
        $project->company->address = $request->address;
        $project->company->zip_code = $request->zip_code;
        $project->company->phone_number = $request->phone_number;
        $project->company->email = $request->email;
        $project->company->save();
        return redirect()->route('admin.projects.companies.indexCompany',$project)->with('message', 'Bedrijf bijgewerkt');
    }
    public function destroyCompany(Project $project,Company $company)
    {
        $project->company->delete();
        return redirect()->route('admin.projects.companies.indexCompany',$project)->with('message', 'Bedrijf verwijdered');
    }
//end functions for company  by project

//start function for my projects in user-side
    public function projectIndex()
    {
        $today = now();
        $projects= Project::where([['start_date', '<=', $today], ['end_date', '>', $today]])->orderBy('end_date', 'asc')->paginate(3);
        return view('projects.index',compact('projects'));
    }
    public function myProjects(Request $request, Project $project)
    {
        $user = Auth::user();
        $projects = Project_User::where('user_id', $request->user()->id)->orderBydesc('created_at')->paginate(30);
        return view('projects.myprojects', compact('projects','user'));
    }


    public function info(Request $request, Project $project, User $user, Task $task,Company $projectcompany)
    {
        $projectcompany = Project::where('company_id' , $project->company->id)->orderBydesc('created_at')->get();
        $user = Project_User::where('user_id', $request->user()->id)->orderBydesc('created_at')->get();
        $tasks = Task::where('project_id', $project->id)->orderBydesc('created_at')->get();
        $projects = Project_User::where('user_id', $request->user()->id)->orderBydesc('created_at')->paginate(30);
        return view('projects.info', compact('projects', 'user','tasks','projectcompany'))->with('project', $project);
    }
//end function  for my projects in user-side


}
