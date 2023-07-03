<?php

namespace App\Helpers;

use App\Models\Admin;
use App\Models\Module;
use App\Models\Page;

class MenuHelper
{
    /**
     * Generates the menu HTML based on the admin's group and modules.
     *
     * @return string
     */
    public static function generateMenuHtml()
    {
        // Fetch the admin data along with the group and modules relationship
        $admin = Admin::with(['group.modules.pages'])->where('id', session('user_uid'))->first();

        // Build the menu data based on the fetched admin data
        $menuData = self::buildMenuData($admin);

        // Build the menu HTML based on the generated menu data
        return self::buildMenu($menuData);
    }

    /**
     * Builds the menu data based on the admin's group and modules.
     *
     * @param Admin $user
     * @return array
     */
    private static function buildMenuData($user)
    {
        $menuData = [];

        // Find and add the Home menu item
        $dashboardModule = Module::where('name', 'dashboard')->first();
        if ($dashboardModule) {
            $menuData[] = [
                'name' => $dashboardModule->title,
                'slug' => $dashboardModule->url,
                'icon' => $dashboardModule->icon_class,
                'url' => '/' . $dashboardModule->url
            ];
        }

        // Fetch all active parent modules
        $parentModules = Module::where('is_parent', true)->where('active', true)->get();

        // Loop through parent modules and create menu items
        foreach ($parentModules as $parentModule) {
            $menuItem = [
                'name' => $parentModule->title,
                'slug' => $parentModule->url,
                'icon' => $parentModule->icon_class,
                'submenu' => []
            ];

            // Fetch all pages that belong to the parent module and are visible to the user's group
            $pages = Page::where('module_id', $parentModule->id)
                ->where(function ($query) use ($user) {
                    $query->where('allowed_groups', 'like', '%' . $user->group_id . '%')
                        ->orWhere('allowed_groups', null);
                })
                ->where('show_menu', true)
                ->get();


            // Loop through the pages and add them to the parent menu
            foreach ($pages as $page) {
                $allowedGroups = explode(',', $page->allowed_groups);
                if (in_array($user->group_id, $allowedGroups) || empty($page->allowed_groups)) {
                    $menuItem['submenu'][] = [
                        'url' => $page->url,
                        'name' => $page->title,
                        'slug' => $page->url
                    ];
                }
            }

            // Fetch all active child modules that belong to the parent module
            $childModules = Module::where('show_to', $parentModule->id)->where('active', true)->get();

            // Loop through child modules and create submenu items
            foreach ($childModules as $childModule) {
                $subMenuItem = [
                    'name' => $childModule->title,
                    'slug' => $childModule->url,
                    'icon' => $childModule->icon_class,
                    'submenu' => []
                ];

                // Fetch all pages that belong to the child module and are visible to the user's group
                $pages = Page::where('module_id', $childModule->id)
                    ->where(function ($query) use ($user) {
                        $query->where('allowed_groups', 'like', '%' . $user->group_id . '%')
                            ->orWhere('allowed_groups', null);
                    })
                    ->where('show_menu', true)
                    ->get();

                // Loop through the pages and add them to the submenu
                foreach ($pages as $page) {
                    $allowedGroups = explode(',', $page->allowed_groups);
                    if (in_array($user->group_id, $allowedGroups) || empty($page->allowed_groups)) {
                        $subMenuItem['submenu'][] = [
                            'url' => $page->url,
                            'name' => $page->title,
                            'slug' => $page->url
                        ];
                    }
                }

                if (!empty($subMenuItem['submenu'])) {
                    $menuItem['submenu'][] = $subMenuItem;
                }
            }


            if (!empty($menuItem['submenu'])) {
                $menuData[] = $menuItem;
            }
        }

        return $menuData;
    }

    /**
     * Builds the menu HTML based on the generated menu data.
     *
     * @param array $menu
     * @param bool $isSubmenu
     * @param bool $parentActive
     * @return string
     */
    private static function buildMenu($menu, $isSubmenu = false, $parentActive = false)
    {
        // Set the opening tag for the menu or submenu list
        $html = $isSubmenu ? '<ul class="menu-sub">' : '<ul class="menu-inner py-1">';

        // Base URL
        $baseUrl = url('/');

        // Iterate through each menu item
        foreach ($menu as $menuItem) {
            $activeClass = '';
            $isCurrentUrl = false;

            // Check if the current menu item has a submenu
            if (isset($menuItem['submenu'])) {

                // Iterate through the submenu items
                foreach ($menuItem['submenu'] as $subMenuItem) {

                    // Check if the submenu item has its own submenu (sub-submenu)
                    if (isset($subMenuItem['submenu'])) {

                        // Iterate through the sub-submenu items
                        foreach ($subMenuItem['submenu'] as $subSubMenuItem) {

                            // Set the current URL flag if the current path matches the sub-submenu item's URL or slug
                            if (request()->path() === trim($subSubMenuItem['slug'], '/') || request()->path() === trim($subSubMenuItem['url'], '/')) {
                                $isCurrentUrl = true;
                                break;
                            }
                        }
                    } else {

                        // Set the current URL flag if the current path matches the submenu item's URL or slug
                        if (isset($subMenuItem['slug']) && request()->path() === trim($subMenuItem['slug'], '/') || isset($subMenuItem['url']) && request()->path() === trim($subMenuItem['url'], '/')) {
                            $isCurrentUrl = true;
                            break;
                        }
                    }
                }
            }

            // Determine the appropriate active class for the menu item
            if ($isCurrentUrl || ($parentActive && !$isSubmenu)) {
                $activeClass .= 'open';
            } elseif ((isset($menuItem['slug']) && request()->path() === trim($menuItem['slug'], '/'))
                || (isset($menuItem['url']) && request()->path() === trim($menuItem['url'], '/'))
            ) {
                $activeClass .= 'active';
            }

            // Build the menu item's HTML structure
            $html .= '<li class="menu-item ' . $activeClass . '" style="">';
            $html .= '<a href="' . (isset($menuItem['url']) ? $baseUrl . '/' . ltrim($menuItem['url'], '/') : 'javascript:void(0);') . '"';
            $html .= isset($menuItem['submenu']) ? ' class="menu-link menu-toggle"' : ' class="menu-link"';
            $html .= '>';

            if (isset($menuItem['icon'])) {
                $html .= '<i class="menu-icon tf-icons ' . $menuItem['icon'] . '"></i>';
            }

            $html .= '<div data-i18n="' . $menuItem['name'] . '">' . $menuItem['name'] . '</div>';
            $html .= '</a>';

            // Build submenu HTML if the current menu item has a submenu
            if (isset($menuItem['submenu'])) {
                $html .= self::buildMenu($menuItem['submenu'], true, $isCurrentUrl);
            }

            $html .= '</li>';
        }

        // Close the menu or submenu list
        $html .= '</ul>';

        return $html;
    }
}
