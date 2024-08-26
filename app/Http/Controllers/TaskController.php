<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return view('task.index', ['tasks' => $tasks]);
    }
    public function create()
    {
        return view('task.create');
    }
    public function store(Request $request)
    {


            $data = $request->all();
       try {
            $task = Task::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'priority'=>$data['priority']
            ]);

                $task->save();



     return redirect()->route('task.create')->with('success', 'Task created successfully!');
            } catch (\Exception $e) {
                //::error('Error sending email', ['error' => $e->getMessage()]);
                return redirect()->route('task.create')->with('error', 'There was an error creating the task.');
            }

    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->name = $request->name;
            $task->description = $request->description;
            $task->priority = $request->priority;
            $task->save();

            return redirect()->route('task.edit',$id)->with('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('task.edit',$id)->with('error', 'An error occurred while updating the task.');
        }
    }

    public function views($id)
    {
        // dd("df");
        $task = Task::find($id);
        return view('task.views', compact('task'));
    }
    public function edit($id)
    {
        // dd("df");
        $task = Task::find($id);
        return view('task.edit', compact('task'));
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully!');
    }
}
