<?php

namespace App\Mail;

use App\Models\pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PagoConfirmadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public pedido $pedido;

    public function __construct(pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        return $this
            ->subject('Pago confirmado - Subastas JOEE')
            ->markdown('emails.pago_confirmado');
    }
}