<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $listing;
    public $resumePath;

    public function __construct($candidate, $listing, $resumePath)
    {
        $this->candidate = $candidate;
        $this->listing = $listing;
        $this->resumePath = $resumePath;
    }

    public function build()
    {
        return $this->subject('New Job Application Received')
                    ->view('emails.employer_application')
                    ->attach(storage_path('app/public/' . $this->resumePath), [
                        'as' => 'resume.' . pathinfo($this->resumePath, PATHINFO_EXTENSION),
                        'mime' => mime_content_type(storage_path('app/public/' . $this->resumePath)),
                    ]);
    }
}
