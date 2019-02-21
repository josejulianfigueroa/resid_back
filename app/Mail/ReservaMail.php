<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fe1;
    public $fe2;
    public $descripcion;
    public $precio;
    public $dias;
    public $nombre;
    public $fecha_re;
    public $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fe1,$fe2,$descripcion,$precio,$dias,$nombre,$fecha_re,$total)
    {
        $this->fe1 = $fe1;
        $this->fe2 = $fe2;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->dias = $dias;
        $this->nombre = $nombre;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Email.reservaMail')->with([
            'fe1' => $this->fe1,
            'fe2' => $this->fe2,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'nombre' => $this->nombre,
            'total' => $this->total
        ]);
    }
}
