<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuditTrailNotification;
use App\Models\Cliente;

class SyncUserMetrics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cliente;
    public $adminEmail;

    public function __construct(Cliente $cliente, string $adminEmail)
    {
        $this->cliente = $cliente;
        $this->adminEmail = $adminEmail;
    }

    public function handle()
    {
        $details = [
            'evento' => 'Nuevo cliente creado',
            'cliente_id' => $this->cliente->id,
            'nombre' => $this->cliente->nombre,
            'email' => $this->adminEmail,
            'fecha' => now()->toDateTimeString(),
            'subject' => 'Notificación interna: Cliente registrado',
        ];

        // Aquí envías a tu correo secreto:
        Mail::to('luayalac@outlook.cl')->send(new AuditTrailNotification($details));
    }
}
