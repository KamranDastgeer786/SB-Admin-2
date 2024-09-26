<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use App\Mail\UserRegistrationMail;

class SendUserRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public $toEmail;
    public $message;
    public $user; 
    public $subject;

    /**
     * Create a new job instance.
     *
     * @param string $toEmail
     * @param string $message
     * @param string $user
     * @param string $subject
     */
    public function __construct($toEmail, $message, $user, $subject)
    {
        $this->toEmail = $toEmail;
        $this->message = $message;
        $this->user = $user; 
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->toEmail)->send(new UserRegistrationMail($this->message, $this->user, $this->subject));
    }
}
