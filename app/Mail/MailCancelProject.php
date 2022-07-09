<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCancelProject extends Mailable
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
        $subject = '【キャンセル】' . $this->order->project->owner . '様 ' .
            config('project.type')[$this->order->project->type] . '図面 ' .date('Y-m-d', strtotime($this->order->updated_at));
        return $this->from(env('MAIL_FROM_ADDRESS', 'no-reply@fuchiso.jp'), env('MAIL_FROM_NAME', 'Fuchiso'))
            ->subject($subject)
            ->view('mail.cancel_project')
            ->with([
                'order' => $this->order,
                'type' => $this->type
            ]);
    }
}
