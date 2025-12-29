<?php

namespace App\Repositories\Admin\MenuItem;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuItemRepository implements MenuItemRepositoryInterface
{
    public function getAll()
    {
        return MenuItem::all();
    }

    public function getMenuItemsByMenuId($menuId)
    {
        return MenuItem::with('menuItemTranslations')
            ->where('menu_id', $menuId)
            ->get();
    }

    public function createMenuItem(Request $request, $menuId)
    {
        return DB::transaction(function () use ($request, $menuId) {
            $defaultLang = array_key_first($request->title);
            $defaultTitle = $request->title[$defaultLang] ?? 'menu-item';

            $slug = Str::slug($defaultTitle);
            $slugCount = MenuItem::where('slug', 'like', "{$slug}%")->count();
            if ($slugCount > 0) {
                $slug .= '-'.($slugCount + 1);
            }

            $menuItem = MenuItem::create([
                'menu_id' => $menuId,
                'slug' => $slug,
                'order_number' => $request->order_number,
                'parent_id' => $request->parent_id ?? null,
            ]);

            foreach ($request->title as $lang => $title) {
                $menuItem->translations()->create([
                    'language_code' => $lang,
                    'title' => $title,
                ]);
            }

            return $menuItem;
        });
    }

    public function updateMenuItem(Request $request, $menuId, $menuItemId)
    {
        $menuItem = MenuItem::with('translations')->findOrFail($menuItemId);
        $slug = Str::slug($request->title[array_key_first($request->title)]);

        $menuItem->update([
            'menu_id' => $request->menu_id,
            'parent_id' => $request->parent_id,
            'order_number' => $request->order_number,
            'slug' => $slug,
        ]);

        foreach ($request->title as $languageCode => $title) {
            $translation = $menuItem->translations()->where('language_code', $languageCode)->first();
            if ($translation) {
                $translation->update(['title' => $title]);
            } else {
                $menuItem->translations()->create([
                    'language_code' => $languageCode,
                    'title' => $title,
                ]);
            }
        }

        $menuItem->translations()->whereNotIn('language_code', array_keys($request->title))->delete();

        return $menuItem;
    }

    public function deleteMenuItem($menuItemId)
    {
        $menuItem = MenuItem::findOrFail($menuItemId);

        return $menuItem->delete();
    }
}
