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

    public Vendor $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this->subject('¡Gracias por tu interés en vender con nosotros!')
            ->markdown('emails.vendors.lead_welcome');
    }
}
