<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreValidation;
use App\Http\Requests\TaskUpdateValidation;
use App\Models\Project;
use App\Models\Project_User;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::orderBydesc('id')->paginate('20');
        return view('admin.tasks.index', compact('tasks'));
    }


    public function create()
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.tasks.create');
    }


    public function search(Request $request)
    {

        $search = $request->input('search');
        $tasks = Task::orWhereRelation('project', 'title', 'LIKE', '%' . $request->search . '%')
            ->orWhere('title', 'LIKE', '%' . $request->search . '%')
            ->paginate(20);

        return view('admin.tasks.index', compact('tasks'));

    }


    public function store(TaskStoreValidation $request, Task $task)
    {
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user()->id;
        $task->project_id = $request->project_id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->completed = $request->completed == 1 ? '1' : '0';
        $task->save();
        return  redirect()->route('admin.tasks.index')->with('message', 'Taak toegevoegd');
    }


    public function show($id)
    {
        //
    }


    public function edit(Task $task)
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.tasks.edit',compact('task'));
    }


    public function update(TaskUpdateValidation $request, Task $task)
    {
        $this->authorize('isAdmin', User::class);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->project_id = $request->project_id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->update();

        return  redirect()->route('admin.tasks.index')->with('message', 'Taak bijgewerkt');
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return  redirect()->route('admin.tasks.index')->with('message', 'Taak verwijdered');
    }

    //start my tasks function in user-side
    public function openTask(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->where('completed', false)->orderBydesc('created_at')->paginate(30);
        return view('tasks.index', compact('tasks'));
    }

    public function completedTask(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->where('completed', true)->orderBydesc('created_at')->paginate(30);
        return view('tasks.completed', compact('tasks'));
    }
    public function isCompleted(Task $task)
    {
        $task->completed = true;
        $task->save();
        return redirect(route('tasks.openTask'))->with('message', 'Taak is afgerond');
    }
    public function isOpened(Task $task)
    {
        $task->completed = false;
        $task->save();
        return redirect(route('tasks.completedTask'))->with('message', 'Taak is open');
    }

    //end my tasks function in user-side
}
