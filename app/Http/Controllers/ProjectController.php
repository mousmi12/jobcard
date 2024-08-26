<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\ProjectCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = DB::table('project as pr')
            ->join('department as dp', 'pr.department', '=', 'dp.id')
            ->join('users as us', 'pr.user', '=', 'us.id')
            ->select('pr.*', 'dp.name as departmentname', 'us.name as username')
            ->where('pr.status', 'Active');
        if ($user->role == 'User') {
            // Add condition to show only projects assigned to the logged-in user
            $query->where('pr.user', $user->id);
        }
        $projects = $query->get();



        return view('project.index', ['projects' => $projects]);
    }
    public function projecttask($pid)
    {
        $project = DB::table('project as p')
            ->select(
                'p.name as projectname',
                'p.id as projectid',
                'p.workstatus as projectwork',
                'u.name as username',
                'p.document as document'
            )
            ->join('users as u', 'u.id', '=', 'p.user')
            ->where('p.id', $pid)
            ->first();

        $tasks = DB::table('task as t')
            ->select('t.name as taskname', 't.id as taskid', 'pt.taskstatus as taskstatus')
            ->join('projecttask as pt', 't.id', '=', 'pt.taskid')
            ->where('pt.projectid', $pid)
            ->get();

        return view('project.projecttask', ['project' => $project, 'tasks' => $tasks]);
    }
    public function updateTaskStatus(Request $request)
    {
        $projectId = $request->projectid;
        $taskStatuses = $request->status;
        $projectWork = $request->projectwork;

        // Check if the project has tasks
        $tasks = DB::table('projecttask')->where('projectid', $projectId)->get();

        if ($tasks->isNotEmpty()) {
            // Update task statuses
            foreach ($taskStatuses as $taskId => $status) {
                DB::table('projecttask')
                    ->where('projectid', $projectId)
                    ->where('taskid', $taskId)
                    ->update(['taskstatus' => $status]);
            }

            // Check if all tasks for the project are completed
            $allTasksCompleted = DB::table('projecttask')
                ->where('projectid', $projectId)
                ->where('taskstatus', '!=', 'Completed')
                ->doesntExist();

            if ($allTasksCompleted) {
                // Update project work status to 'Completed'
                DB::table('project')
                    ->where('id', $projectId)
                    ->update(['workstatus' => 'Completed']);
            }
        } else {
            // Update project status if there are no tasks
            if ($projectWork) {
                DB::table('project')
                    ->where('id', $projectId)
                    ->update(['workstatus' => $projectWork]);
            }
        }

        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            DB::table('project')
                ->where('id', $projectId)
                ->update(['document' => $filename]);
        }

        // Retrieve updated project and tasks
        $project = DB::table('project as p')
            ->select(
                'p.name as projectname',
                'p.id as projectid',
                'p.workstatus as projectwork',
                'u.name as username',
                'p.document as document'
            )
            ->join('users as u', 'u.id', '=', 'p.user')
            ->where('p.id', $projectId)
            ->first();

        $tasks = DB::table('task as t')
            ->select('t.name as taskname', 't.id as taskid', 'pt.taskstatus as taskstatus')
            ->join('projecttask as pt', 't.id', '=', 'pt.taskid')
            ->where('pt.projectid', $projectId)
            ->get();

        // Return the view with updated data and status message
        return view('project.projecttask', ['project' => $project, 'tasks' => $tasks])->with('status', 'Status updated successfully!');
    }



    public function create()
    {
        $departments = Department::all();
        return view('project.create', compact('departments'));
    }
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $project = Project::create([
                'name' => $data['name'],
                'user' => $data['user'],
                'department' => $data['department'],
                'description' => $data['description'],
                'priority' => $data['priority'],
                'startdate' => $data['start_date'],
                'enddate' => $data['end_date']
            ]);

            // Save the project first
            $project->save();

            // If there are tasks, insert them into the projecttask table
            if (isset($data['tasks'])) {
                foreach ($data['tasks'] as $taskId) {
                    DB::table('projecttask')->insert([
                        'projectid' => $project->id,
                        'taskid' => $taskId
                    ]);
                }
            }
            // Retrieve user and department models
            $user = User::find($data['user']);
            $department = Department::find($data['department']);

            // Send email to the Managing Director
            Mail::to('reseenarejmel@gmail.com')->send(new ProjectCreated($project, $user, $department));

            Log::info('Email sent to reseenarejmel@gmail.com');

            return redirect()->route('project.create')->with('success', 'Project created successfully!');
        } catch (\Exception $e) {
            Log::error('Error sending email', ['error' => $e->getMessage()]);
            return redirect()->route('project.create')->with('error', 'There was an error creating the project.');
        }
    }



    public function update(Request $request, $id)
    {
        try {

            // $project = Project::findOrFail($id);
            // $project->name = $request->name;
            // $project->user = $request->user;
            // $project->description = $request->description;
            // $project->priority = $request->priority;
            // $project->save();

            // return redirect()->route('project.index')->with('success', 'project updated successfully!');
            $data = $request->all();

            // Update project details
            DB::table('project')
                ->where('id', $id)
                ->update([
                    'name' => $data['name'],
                    'user' => $data['user'],
                    'department' => $data['department'],
                    'description' => $data['description'],
                    'priority' => $data['priority'],
                    'startdate' => $data['start_date'],
                    'enddate' => $data['end_date']
                ]);

            // Sync the tasks
            if (isset($data['tasks']) && is_array($data['tasks'])) {
                // First, delete existing project tasks
                DB::table('projecttask')
                    ->where('projectid', $id)
                    ->delete();

                // Insert new project tasks
                foreach ($data['tasks'] as $task_id) {
                    DB::table('projecttask')->insert([
                        'projectid' => $id,
                        'taskid' => $task_id,
                    ]);
                }
            } else {
                // If no tasks are selected, delete all project tasks
                DB::table('projecttask')
                    ->where('projectid', $id)
                    ->delete();
            }

            return redirect()->route('project.edit',$id)->with('success', 'Project updated successfully!');
        } catch (\Exception $e) {
            //dd($e);
            return redirect()->route('project.edit',$id)->with('error', 'There was an error creating the project.');
        }
    }
    public function views($id)
    {
        // dd("df");
        $project = DB::table('project as pr')
            ->join('department as dp', 'pr.department', '=', 'dp.id')
            ->join('users as us', 'pr.user', '=', 'us.id')
            ->select('pr.*', 'dp.name as departmentname', 'us.name as username')
            ->where('pr.status', 'Active')
            ->where('pr.id', $id)
            ->first();
        return view('project.views', compact('project'));
    }
    public function edit($id)
    {
        // Fetch project details
        $project = DB::table('project as pr')
            ->join('department as dp', 'pr.department', '=', 'dp.id')
            ->join('users as us', 'pr.user', '=', 'us.id')
            ->select('pr.*', 'dp.name as departmentname', 'us.name as username')
            ->where('pr.status', 'Active')
            ->where('pr.id', $id)
            ->first();

        // Fetch all departments and users for dropdowns
        $departments = DB::table('department')->pluck('name', 'id');
        $users = DB::table('users')->pluck('name', 'id');

        // Fetch all tasks
        $tasks = DB::table('task')->get();

        // Fetch tasks associated with the project
        $project_tasks = DB::table('projecttask')
            ->where('projectid', $id)
            ->pluck('taskid')
            ->toArray();

        return view('project.edit', compact('project', 'departments', 'users', 'tasks', 'project_tasks'));
    }
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('project.index')->with('success', 'project deleted successfully!');
    }
    public function getUsersByDepartment($id)
    {
        $users = User::where('department', $id)->get();
        return response()->json($users);
    }
    public function getTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }
}
