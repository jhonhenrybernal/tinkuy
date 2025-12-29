<?php

namespace App\Repositories\Admin\Category;

interface CategoryRepositoryInterface
{
    public function all();

    public function find($id);

    public function store($data);

    public function update($id, array $data);

    public function destroy($id);
}
