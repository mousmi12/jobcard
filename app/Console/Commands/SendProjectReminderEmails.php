<?php

namespace App\Console\Commands;

use App\Mail\ProjectCreated;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendProjectReminderEmails extends Command
{
    protected $signature = 'email:send-project-reminders';
    protected $description = 'Send email reminders for projects nearing their end date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $threeDaysFromNow = Carbon::now()->addDays(-3)->toDateString();
//dd($threeDaysFromNow);
        $projects = Project::where('enddate', $threeDaysFromNow)
                           ->where('workstatus', '!=', 'Completed')
                           ->get();

        foreach ($projects as $project) {
            $user = User::find($project->user); // Assuming you have a relationship set up
            $department = Department::find($project->department); // Assuming you have a relationship set up

            Mail::to('reseenarejmel@gmail.com')->send(new ProjectCreated($project, $user, $department, true));
        }

        $this->info('Project reminder emails sent successfully!');
    }
}
