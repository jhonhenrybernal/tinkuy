<?php

namespace App\Repositories\Admin\Attribute;

use App\Models\Attribute;

interface AttributeRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function store(array $data);

    public function update(Attribute $attribute, array $data);

    public function delete($id);
}
