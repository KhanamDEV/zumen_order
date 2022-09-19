<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCreateProject extends Mailable
{
    use Queueable, SerializesModels;


    private $type;
    private $order;
    private $mailFeedback;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $order, $mailFeedback = false)
    {
        $this->type = $type;
        $this->order = $order;
        $this->mailFeedback = $mailFeedback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = $this->mailFeedback ? 'フィードバック' : '発注';
        $subject = "【".$title."】" . $this->order->project->owner . '様 ' .
            config('project.type')[$this->order->project->type] . '図面 ' .
            (!empty($this->order->project->importunate) ? '納期相談希望' : $this->order->project->delivery_date);
        return $this->from(env('MAIL_FROM_ADDRESS', 'no-reply@fuchiso.jp'), env('MAIL_FROM_NAME', 'Fuchiso'))
            ->subject($subject)
            ->view('mail.new_project')
            ->with([
                'order' => $this->order,
                'type' => $this->type,
                'mailFeedback' => $this->mailFeedback
            ]);
    }
}
