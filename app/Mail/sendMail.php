<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $pdf;
    public $nota;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $pdf, $nota)
    {
        $this->data = $data;
        $this->pdf = $pdf;
        $this->nota = $nota;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['subject'])
            ->view('tiketmail')
            ->attach($this->pdf)
            ->attach($this->nota);
    }
}
