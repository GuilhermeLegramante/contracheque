<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviaPin extends Mailable
{
    use Queueable, SerializesModels;

    private $cpf;
    private $pin;
    public $subject = "PIN hsContracheque";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cpf, $pin)
    {
        $this->cpf = $cpf;
        $this->pin = $pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cpf = $this->cpf;
        $pin = $this->pin;
        return $this->view('auth.emailPin', compact('cpf', 'pin'));
    }
}
