<?php

namespace PBW\Wordpress;

defined('ABSPATH') || exit('No direct script access allowed');

class AssetsHooks
{
    public static function init(): void
    {
        $handler = new self();
        add_action('admin_enqueue_scripts', [$handler, 'adminEnqueueScripts']);
        add_action('wp_enqueue_scripts', [$handler, 'wpEnqueueScripts']);
    }

    public function adminEnqueueScripts(): void
    {
        if (get_post_type() === 'product') :
            wp_enqueue_style(
                'pbw-admin',
                plugins_url('/app/assets/css/admin.css', PBW_FILE),
                [],
                uniqid()
            );

            wp_enqueue_script(
                'pbw-admin',
                plugins_url('/app/assets/js/admin.min.js', PBW_FILE),
                ['jquery'],
                uniqid(),
                true
            );
        endif;
    }

    public function wpEnqueueScripts(): void
    {
        if (is_singular('product')) :
            $product = pbw_getProduct(get_the_ID());
            if ($product->isActive()) :
                wp_enqueue_style(
                    'pbw-product',
                    plugins_url('/app/assets/css/single-product.css', PBW_FILE),
                    [],
                    uniqid()
                );

                wp_enqueue_script(
                    'pbw-product',
                    plugins_url('/app/assets/js/single-product.min.js', PBW_FILE),
                    ['jquery'],
                    uniqid(),
                    true
                );
            endif;
        endif;
    }
}

AssetsHooks::init();