<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployerWithdrawn extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.application_withdrawn_emp',
            with: ['application' => $this->application],
        );
    }

    /**
     * Get the message envelope definition.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Withdrawn',
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
}
