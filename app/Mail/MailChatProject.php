<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailChatProject extends Mailable
{
    use Queueable, SerializesModels;

    private $type;
    private $message;
    private $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $message, $order)
    {
        $this->type = $type;
        $this->message = $message;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '【メッセージ】' . $this->order->project->owner . '様 ' .
            config('project.type')[$this->order->project->type] . '図面 ' .date('Y-m-d');
        return $this->from(env('MAIL_FROM_ADDRESS', 'no-reply@fuchiso.jp'), env('MAIL_FROM_NAME', 'Fuchiso'))
            ->subject($subject)
            ->view('mail.new_message')
            ->with([
                'chat' => $this->message,
                'type' => $this->type,
                'order' => $this->order
            ]);
    }
}
