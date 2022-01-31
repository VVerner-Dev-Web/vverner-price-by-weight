<?php

namespace PBW\Wordpress;

defined('ABSPATH') || exit('No direct script access allowed');

class SettingsHooks
{
    public static function init(): void
    {
        $handler = new self();
        add_action('admin_menu', [$handler, 'enqueueSettingsPage']);
    }

    public function enqueueSettingsPage(): void
    {
        add_submenu_page(
            'woocommerce',
            'Configurações de preço por peso',
            'Preço por peso',
            'edit_posts',
            'pbw-global-settings',
            [$this, 'loadSettingsView']
        );
    }

    public function loadSettingsView(): void
    {
        pbw_getApp()->loadView('admin/global-settings');
    }
}

SettingsHooks::init();