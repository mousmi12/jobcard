<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $user;
    public $department;
    public $reminder;

    /**
     * Create a new message instance.
     *
     * @param $project
     * @param $user
     * @param $department
     * @param $reminder
     */
    public function __construct($project, $user, $department, $reminder = false)
    {
        $this->project = $project;
        $this->user = $user;
        $this->department = $department;
        $this->reminder = $reminder;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->reminder ? 'Project Reminder: End Date Approaching' : 'New Project Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.project_created',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->subject($this->reminder ? 'Project Reminder: End Date Approaching' : 'New Project Created')
                    ->view('email.project_created')
                    ->with([
                        'project' => $this->project,
                        'user' => $this->user,
                        'department' => $this->department,
                        'reminder' => $this->reminder
                    ]);
    }
}

