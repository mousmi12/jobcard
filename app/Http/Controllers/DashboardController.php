<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $userId = $user->id;
    $isUser = $user->role == 'User';

    // Queries for project counts and priority counts
    $projectQuery = DB::table('department as d')
        ->join('project as p', 'p.department', '=', 'd.id')
        ->select(DB::raw('COUNT(*) as project_count'), 'd.name')
        ->groupBy('d.id', 'd.name');

    $priorityQuery = DB::table('department as d')
        ->join('project as p', 'p.department', '=', 'd.id')
        ->select(DB::raw('COUNT(*) as priority_count'), 'd.name')
        ->where('p.priority', 'High')
        ->groupBy('d.id', 'd.name');

    // Modify queries for non-admin users
    if ($isUser) {
        $projectQuery->where('p.user', $userId);
        $priorityQuery->where('p.user', $userId);
    }

    $activeProjectCount = Project::where('status', 'active')
        ->when($isUser, function ($query) use ($userId) {
            return $query->where('user', $userId);
        })
        ->count();

    $results = $projectQuery->get();
    $priorityCounts = $priorityQuery->get()->keyBy('name');

    // Fetch active users and their projects
    $activeUsersProjects = DB::select('
        SELECT u.name AS username, p.name AS projectname
        FROM users u, project p
        WHERE u.id = p.user
        AND u.status = "Active"
        ' . ($isUser ? 'AND u.id = ?' : ''), $isUser ? [$userId] : []);

    // Query for project progress
    $query = DB::table('project as p')
        ->select('p.id', 'p.name', 'p.workstatus')
        ->selectRaw('
            ROUND(
                IFNULL(
                    SUM(CASE
                        WHEN pt.taskstatus = "Completed" THEN 1
                        WHEN pt.taskstatus = "In Progress" THEN 0.5
                        ELSE 0
                    END) / COUNT(pt.taskid) * 100,
                    0
                ),
            2) as status_percentage
        ')
        ->leftJoin('projecttask as pt', 'p.id', '=', 'pt.projectid')
        ->groupBy('p.id', 'p.name', 'p.workstatus')
        ->when($isUser, function ($query) use ($userId) {
            return $query->where('p.user', $userId);
        });

    $projects = $query->get();

    // Merge the priority counts into the results
    foreach ($results as $result) {
        $result->priority_count = $priorityCounts->has($result->name) ? $priorityCounts->get($result->name)->priority_count : 0;
    }

    return view('dashboard', compact('activeProjectCount', 'results', 'projects', 'activeUsersProjects'));
}

    // public function calculateStatus()
    // {
    //     $totalTasks = $this->tasks()->count();
    //     if ($totalTasks === 0) {
    //         return 0;
    //     }

    //     $statusWeights = [
    //         'pending' => 0,
    //         'in progress' => 0.5,
    //         'completed' => 1
    //     ];

    //     $statusCounts = $this->tasks()
    //         ->selectRaw('status, count(*) as count')
    //         ->groupBy('status')
    //         ->pluck('count', 'status')
    //         ->toArray();

    //     $totalWeight = 0;
    //     foreach ($statusCounts as $status => $count) {
    //         $totalWeight += $statusWeights[$status] * $count;
    //     }

    //     $completionPercentage = ($totalWeight / $totalTasks) * 100;

    //     return round($completionPercentage, 2);
    // }
}
