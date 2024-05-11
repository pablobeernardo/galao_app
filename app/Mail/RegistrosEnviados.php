<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrosEnviados extends Mailable
{
    use Queueable, SerializesModels;

    public $registros;
    public $galao;
    public $anexos;

    public function __construct($registros, $galao, $anexos)
    {
        $this->registros = $registros;
        $this->galao = $galao;
        $this->anexos = $anexos;
    }

    public function build()
    {
        $mail = $this->view('emails.registros-enviados');

        foreach ($this->anexos as $anexo) {
            $mail->attachData($anexo['data'], $anexo['filename']);
        }

        return $mail;
    }
}
