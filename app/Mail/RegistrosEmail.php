<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Registro;
use App\Models\Galao;

class RegistrosEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $registros;
    public $galao;

    public function __construct($registros, $galao)
    {
        $this->registros = $registros;
        $this->galao = $galao;
    }

    public function build()
    {
        return $this->markdown('mail.registros_email')
                    ->with([
                        'registros' => $this->registros,
                        'galao' => $this->galao
                    ]);
    }
}
