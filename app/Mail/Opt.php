<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Opt extends Mailable
{
    use Queueable, SerializesModels;
    private $_text, $_subjectLine ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($text, $subjectLine)
    {
        $this->_text = $text;
        $this->__subjectLine = $subjectLine;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->__subjectLine)->view('emails.otp')->with(["text" => $this->_text]);
    }
}
