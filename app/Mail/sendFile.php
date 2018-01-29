<?php

namespace App\Mail;

use App\Models\Proyecto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendFile extends Mailable
{
    use Queueable, SerializesModels;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $nombre, $extension)
    {
        $this->url = $url;
        $this->nombre = $nombre;
        $this->extension = $extension;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.emailFile')
            ->subject('Trabajo especial de Grado Solicitado: '.$this->nombre)
            ->from('iutasiap@gmail.com', 'IUTA SIAP')
            ->with(['nombre' => $this->nombre, 'url' => $this->url]);
    }
}
