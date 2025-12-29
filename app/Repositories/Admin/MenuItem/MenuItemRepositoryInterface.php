<?php

namespace App\Repositories\Admin\MenuItem;

use Illuminate\Http\Request;

interface MenuItemRepositoryInterface
{
    public function getAll();

    public function getMenuItemsByMenuId($menuId);

    public function createMenuItem(Request $request, $menuId);

    public function updateMenuItem(Request $request, $menuId, $menuItemId);

    public function deleteMenuItem($menuItemId);
}
