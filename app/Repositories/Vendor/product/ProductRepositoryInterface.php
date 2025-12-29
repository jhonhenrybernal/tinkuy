<?php

namespace App\Repositories\Vendor\Product;

interface ProductRepositoryInterface
{
    public function all();

    public function find($id);

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);
}
