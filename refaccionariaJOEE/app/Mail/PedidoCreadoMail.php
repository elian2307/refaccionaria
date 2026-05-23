<?php

namespace App\Mail;

use App\Models\pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoCreadoMail extends Mailable
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
            ->subject('Tu oferta fue aceptada - Pago pendiente')
            ->markdown('emails.pedido_creado');
    }
}