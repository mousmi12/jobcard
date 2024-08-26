<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $query = DB::table('project as p')
        ->join('department as d', 'p.department', '=', 'd.id')
        ->join('users as u', 'p.user', '=', 'u.id')
        ->leftJoin('projecttask as pt', 'p.id', '=', 'pt.projectid')
        ->select(
            'p.id',
            'p.name as projectname',
            'u.name as username',
            'd.name as departmentname',
            DB::raw('MAX(p.status) as status'),
            DB::raw('MAX(p.priority) as priority'),
            DB::raw('MAX(p.workstatus) as workstatus'),
            DB::raw('MAX(p.enddate) as enddate'),  // Added end date
            DB::raw("
                CASE
                    WHEN COUNT(pt.id) = 0 THEN
                        CASE
                            WHEN MAX(p.workstatus) = 'Pending' THEN 1
                            WHEN MAX(p.workstatus) = 'In Progress' THEN 0
                            ELSE 0
                        END
                    ELSE SUM(CASE WHEN pt.taskstatus = 'Pending' THEN 1 ELSE 0 END)
                END as pending_tasks
            "),
            DB::raw("
                CASE
                    WHEN COUNT(pt.id) = 0 THEN
                        CASE
                            WHEN MAX(p.workstatus) = 'In Progress' THEN 1
                            ELSE 0
                        END
                    ELSE SUM(CASE WHEN pt.taskstatus = 'In Progress' THEN 1 ELSE 0 END)
                END as in_progress_tasks
            "),
            DB::raw("
                CASE
                    WHEN COUNT(pt.id) = 0 THEN
                        CASE
                            WHEN MAX(p.workstatus) = 'Completed' THEN 1
                            ELSE 0
                        END
                    ELSE SUM(CASE WHEN pt.taskstatus = 'Completed' THEN 1 ELSE 0 END)
                END as completed_tasks
            ")
        )
        ->groupBy('p.id', 'p.name', 'u.name', 'd.name')
        ->orderByRaw("
            CASE
                WHEN MAX(p.workstatus) IN ('Pending', 'In Progress') THEN 1
                ELSE 2
            END,
            CASE
                WHEN MAX(p.workstatus) IN ('Pending', 'In Progress') THEN MAX(p.enddate)
                ELSE NULL
            END ASC,
            CASE
                WHEN MAX(p.priority) = 'High' AND MAX(p.workstatus) != 'Completed' THEN 1
                WHEN MAX(p.workstatus) != 'Completed' THEN 2
                ELSE 3
            END,
            FIELD(MAX(p.priority), 'High', 'Medium', 'Low')
        ");

    if ($user->role == 'User') {
        $query->where('p.user', $user->id);
    }

    $projects = $query->get();
    return view('report', compact('projects'));
}




}
