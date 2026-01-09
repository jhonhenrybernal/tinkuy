<?php

namespace App\Mail;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorNotApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Vendor $vendor;
    public array $items;

    public function __construct(Vendor $vendor, array $items)
    {
        $this->vendor = $vendor;
        $this->items = $items;
    }

    public function build()
    {
        return $this
            ->subject('Tu solicitud requiere ajustes para ser aprobada')
            ->markdown('emails.vendors.not_approved'); // <- ruta del blade
    }
}
