<?php

namespace PBW;

defined('ABSPATH') || exit('No direct script access allowed');

class App
{
    private const PREFIX = '_pbw-';
    
    public function get(string $prop)
    {
        return get_option(self::PREFIX . $prop, null);
    }

    public function set(string $prop, $value): void
    {
        update_option(self::PREFIX . $prop, $value, false);
    }

    public function loadView(string $view): void
    {
        $file = PBW_VIEWS . '/' . $view . '.php';

        if (file_exists($file)) : 
            require_once $file;
        else : 
            echo 'View not found: ' . $view;
        endif;
    }
}
