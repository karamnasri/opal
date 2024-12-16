<?php

namespace App\Jobs;

use App\DTOs\Auth\ResetLinkDTO;
use App\Mail\PasswordResetLinkMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetLinkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public ResetLinkDTO $data) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->data->email)->send(new PasswordResetLinkMail($this->data));
    }
}
