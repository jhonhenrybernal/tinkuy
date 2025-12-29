<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\VendorRepository;

class VendorService
{
    protected $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function getVendorByEmail(string $email)
    {
        return $this->vendorRepository->findByEmail($email);
    }
}
