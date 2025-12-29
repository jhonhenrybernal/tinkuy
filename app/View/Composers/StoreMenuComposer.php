<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class StoreMenuComposer
{
    public function compose(View $view)
    {
        if (Schema::hasTable('menus')) {
            $locale = app()->getLocale();

            $headerMenu = Menu::where('status', 1)
                ->with([
                    'menuItems' => function ($query) use ($locale) {
                        $query->orderBy('order_number', 'asc')
                            ->with(['translation' => function ($query) use ($locale) {
                                $query->where('language_code', $locale);
                            }]);
                    },
                ])
                ->first();

            $view->with('headerMenu', $headerMenu);
        }
    }
}
