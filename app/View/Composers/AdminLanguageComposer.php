<?php

namespace App\View\Composers;

use App\Models\Language;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminLanguageComposer
{
    public function compose(View $view)
    {
        if (Schema::hasTable('menus')) {
            $view->with('menu', Menu::first());
        }

        if (Schema::hasTable('languages')) {
            $activeLanguages = Language::where('active', 1)->get();
            $view->with('activeLanguages', $activeLanguages);
        }
    }
}
