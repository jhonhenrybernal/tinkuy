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


    public function __construct(
        public Vendor $vendor,
        public ?string $adminVendorUrl = null,
        public ?string $landingUrl = null
    ) {}

    public function build()
    {
        return $this
            ->subject('Nuevo prospecto de proveedor: ' . $this->vendor->name)
            ->markdown('emails.vendors.lead_admin_notification')
            ->with([
                'vendor' => $this->vendor,
                'adminVendorUrl' => $this->adminVendorUrl ?? url('/admin/vendors/' . $this->vendor->id . '/edit'),
                'landingUrl' => $this->landingUrl ?? url('/vender'),
            ]);
    }
}
