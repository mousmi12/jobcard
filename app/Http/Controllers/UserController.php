<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $query = DB::table('users as us')
            ->join('department as dept', 'dept.id', '=', 'us.department')
            ->select('us.*', 'dept.name as departmentname')
            ->where('us.status', 'Active');
        if ($user->role == 'User') {
            // Add condition to show only projects assigned to the logged-in user
            $query->where('us.id', $user->id);
        }
        $users = $query->get();

        return view('user.index', ['users' => $users]);
    }
    public function create()
    {
        $departments = Department::all();
        return view('user.create', compact('departments'));
    }
    public function store(Request $request)
    {
        try {
            // dd($request);
            // Validate the request data
            $request->validate([
                'name' => 'required',
                'mobile' => 'required',
                'qualification' => 'required',
                'department' => 'required',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'role' => 'required',
            ]);
            //dd($request);
            // Get all request data
            $data = $request->all();

            // Create the user with hashed password
            $user = User::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'qualification' => $data['qualification'],
                'department' => $data['department'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            // Optional: You can remove this debug line after testing
            //  dd($user);

            return redirect()->route('user.create')->with('success', 'User created successfully!');
        } catch (ValidationException $e) {
            // dd($e);
            // Handle validation errors
            return redirect()->route('user.create')
                ->withErrors($e->validator)
                ->withInput();
        } catch (QueryException $e) {
            dd($e);
            // Handle database query errors
            return redirect()->route('user.create')
                ->with('error', 'Database error: ' . $e->getMessage())
                ->withInput();
        } catch (\Exception $e) {
            //dd($e);
            // Handle any other exceptions
            return redirect()->route('user.create')
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->department = $request->department;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->mobile = $request->mobile;
            $user->status = $request->status;
            $user->role = $request->role;
            $user->save();
            return redirect()->route('user.edit', $id)->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            //dd($e);
            return redirect()->route('user.edit', $id)->with('error', 'There was an error creating the user.');
        }
        //return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }
    public function views($id)
    {
        //dd("df");
        $user = DB::table('users as us')
            ->join('department as dept', 'dept.id', '=', 'us.department')
            ->select('us.*', 'dept.name as departmentname')
            ->where('us.status', 'Active')
            ->where('us.id', $id)
            ->first();
        return view('user.views', compact('user'));
    }
    public function edit($id)
    {
        $user = DB::table('users as us')
            ->join('department as dept', 'dept.id', '=', 'us.department')
            ->select('us.*', 'dept.name as departmentname')
            ->where('us.status', 'Active')
            ->where('us.id', $id)
            ->first();
        $departments = Department::pluck('name', 'id');
        return view('user.edit', compact('user', 'departments'));
    }
    public function destroy($id)
    {
        //dd($id);
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully!');
    }
}
