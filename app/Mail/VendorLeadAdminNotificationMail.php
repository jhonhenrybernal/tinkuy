<?php
namespace App\Mail;

use App\Models\Vendor;
use App\Models\VendorLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorLeadAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Vendor $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this->subject('Nuevo prospecto de proveedor registrado')
            ->markdown('emails.vendors.lead_admin_notification');
    }
}
