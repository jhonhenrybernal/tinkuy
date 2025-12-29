<?php

namespace App\Repositories\Admin\Menu;

use App\Models\Menu;

class MenuRepository implements MenuRepositoryInterface
{
    public function all()
    {
        return Menu::all();
    }

    public function find($id)
    {
        return Menu::findOrFail($id);
    }

    public function create(array $data)
    {
        return Menu::create($data);
    }

    public function update($id, array $data)
    {
        $menu = $this->find($id);

        return $menu->update($data);
    }

    public function delete($id)
    {
        $menu = $this->find($id);

        return $menu->delete();
    }
}
