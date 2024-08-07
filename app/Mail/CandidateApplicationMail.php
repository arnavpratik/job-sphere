<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $listing;

    public function __construct($candidate, $listing)
    {
        $this->candidate = $candidate;
        $this->listing = $listing;
    }

    public function build()
    {
        return $this->subject('Job Application Submitted')
                    ->view('emails.candidate_application');
    }
}
