<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailContinueProject extends Mailable
{
    use Queueable, SerializesModels;

    private $type;
    private $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $order)
    {
        $this->type = $type;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '【続き】' . $this->order->project->user->first_name . $this->order->project->user->last_name . '様 ' .
            config('project.type')[$this->order->project->type] . '図面 ' .date('Y-m-d', strtotime($this->order->updated_at));
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($subject)
            ->view('mail.continue_project')
            ->with([
                'order' => $this->order,
                'type' => $this->type
            ]);
    }
}
