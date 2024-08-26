<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function create()
    {
        $departments = Department::all();

        return view ('department.create',['departments'=>$departments]);

    }
    public function store(Request $request)
    {
        //dd($request);
        $data = $request->all();

        $department = Department::create([
            'name' => $data['name'],

            'status'=>$data['status']
        ]);

            $department->save();

            $departments = Department::all();
        return view('department.create',['departments'=>$departments]);
    }
    public function update(Request $request, $id)
    {

        $department = Department::findOrFail($id);
        $department->status = $request->status;
        $department->save();

        return response()->json(['success' => true]);
    }
    public function destroy($id)
    {
        $project = Department::findOrFail($id);
        $project->delete();

        return response()->json(['success' => true]);
    }
}
