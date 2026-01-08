<?php

namespace App\Mail;

use App\Models\Vendor;
use App\Models\VendorLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorLeadWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

   
    public function __construct(
        public Vendor $vendor,
        public ?string $landingUrl = null
    ) {}

    public function build()
    {
        return $this
            ->subject('¡Gracias por tu interés en vender con nosotros!')
            ->markdown('emails.vendors.lead_welcome')
            ->with([
                'vendor' => $this->vendor,
                'landingUrl' => $this->landingUrl ?? url('/vender'), // ajusta tu ruta
            ]);
    }
}
