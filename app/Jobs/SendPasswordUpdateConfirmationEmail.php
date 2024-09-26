<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordUpdateConfirmationMail;

class SendPasswordUpdateConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $toEmail;
    public $user; 
    public $subject;

    /**
    * Create a new job instance.
    *
    * @param string $toEmail
    * @param string $user
    * @param string $subject
    */
    public function __construct($toEmail, $user, $subject)
    {
        $this->toEmail = $toEmail;
        $this->user = $user; 
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->toEmail)->send(new PasswordUpdateConfirmationMail( $this->user, $this->subject));
    }
}
