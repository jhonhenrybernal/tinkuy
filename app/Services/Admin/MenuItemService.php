<?php

namespace App\Services\Admin;

use App\Repositories\Admin\MenuItem\MenuItemRepositoryInterface;
use Illuminate\Http\Request;

class MenuItemService
{
    protected $menuItemRepository;

    public function __construct(MenuItemRepositoryInterface $menuItemRepository)
    {
        $this->menuItemRepository = $menuItemRepository;
    }

    public function getAllMenuItems()
    {
        return $this->menuItemRepository->getAll();
    }

    public function getMenuItemsByMenuId($menuId)
    {
        return $this->menuItemRepository->getMenuItemsByMenuId($menuId);
    }

    public function createMenuItem(Request $request, $menuId)
    {
        return $this->menuItemRepository->createMenuItem($request, $menuId);
    }

    public function updateMenuItem(Request $request, $menuId, $menuItemId)
    {
        return $this->menuItemRepository->updateMenuItem($request, $menuId, $menuItemId);
    }

    public function deleteMenuItem($menuItemId)
    {
        return $this->menuItemRepository->deleteMenuItem($menuItemId);
    }
}
