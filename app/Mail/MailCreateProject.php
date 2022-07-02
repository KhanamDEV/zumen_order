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
        $subject = '【発注】' . $this->order->project->user->first_name . $this->order->project->user->last_name . '様 ' .
            config('project.type')[$this->order->project->type] . '図面 ' .
            (!empty($this->order->project->importunate) ? '納期相談希望' : $this->order->project->delivery_date);
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($subject)
            ->view('mail.new_project')
            ->with([
                'order' => $this->order,
                'type' => $this->type
            ]);
    }
}
