<?php

namespace App\Jobs;

use App\Mail\MailContinueProject;
use App\Mail\MailLeaveProject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailLeaveProjectSingle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $type;
    private $order;
    private $to;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $order, $to)
    {
        $this->type = $type;
        $this->order = $order;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new MailLeaveProject($this->type, $this->order));
    }
}
