<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CargaPagoReservaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $desc;
    public $nombre;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($st,$ds,$no)
    {
        $this->status = $st;
        $this->desc = $ds;
        $this->nombre = $no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Email.cambioEstadoReserva')->with([
            'st' => $this->status,
            'ds' => $this->desc,
            'no' => $this->nombre
        ]);
    }
}
