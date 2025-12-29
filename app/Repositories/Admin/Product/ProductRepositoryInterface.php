<?php

// app/Repositories/Admin/Product/ProductRepositoryInterface.php

namespace App\Repositories\Admin\Product;

interface ProductRepositoryInterface
{
    public function all();

    public function find($id);

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);
}
