<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueueMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    private $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
        $this->subject = "Teste FILA: " . config('app.name') . ' - ' . session()->get('clientName');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $content = $this->content;

        $content['queueName'] = env('SQS_QUEUE');

        return $this->markdown('mails.queue')->with(['content' => $content]);
    }
}
