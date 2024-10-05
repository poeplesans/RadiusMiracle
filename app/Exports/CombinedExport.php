<?php

namespace App\Exports;

use App\Models\Menu;
use App\Models\Header;
use App\Models\SubMenu;
use App\Helpers\DatabaseHelper;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CombinedExport implements WithMultipleSheets
{
    /**
     * Return an array of sheets.
     */
    public function sheets(): array
    {
        DatabaseHelper::setDynamicConnection();
        return [
            new HeadersSheet(),
            new MenusSheet(),
            new SubMenusSheet(),
        ];
    }
}

/**
 * Sheet for Headers data
 */
class HeadersSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        // Hanya ambil kolom yang diinginkan, tidak termasuk created_at dan updated_at
        return Header::select('name')->get();
    }

    public function title(): string
    {
        return 'Headers';
    }
}

/**
 * Sheet for Menus data
 */
class MenusSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        // Ambil kolom yang diinginkan, ganti header_id dengan nama header
        return Menu::with('header')->get()->map(function($menu) {
            return [
                // 'id' => $menu->id,
                'header_name' => $menu->header->name, // Mengambil nama header
                'name' => $menu->name,
                'icon' => $menu->icon
            ];
        });
    }

    public function title(): string
    {
        return 'Menus';
    }
}


/**
 * Sheet for SubMenus data
 */
class SubMenusSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        // Ambil kolom yang diinginkan, tidak termasuk created_at dan updated_at
        return SubMenu::with('menu')->get()->map(function($submenu) {
            return [
                // 'id' => $submenu->id,
                'menu_id' => $submenu->menu->name, // Mengambil nama header
                'name' => $submenu->name,
                'url' => $submenu->icon
            ];
        });
    }

    public function title(): string
    {
        return 'SubMenus';
    }
}

