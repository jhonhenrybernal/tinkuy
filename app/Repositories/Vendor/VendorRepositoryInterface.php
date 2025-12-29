<?php

namespace App\Repositories\Vendor;

interface VendorRepositoryInterface
{
    public function findByEmail(string $email);
}
