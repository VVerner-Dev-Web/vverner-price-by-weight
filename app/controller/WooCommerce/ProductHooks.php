<?php 

namespace PBW\WooCommerce;

defined('ABSPATH') || exit('No direct script access allowed');

class ProductHooks
{
    public static function init(): void
    {
        $handler = new self();
        add_action('woocommerce_product_options_general_product_data', [$handler, 'enqueueProductFields']);
        add_action('woocommerce_process_product_meta', [$handler, 'handleProductUpdate'], 999);
    }

    public function enqueueProductFields(): void
    {
        pbw_getApp()->loadView('admin/product-settings');
    }

    public function handleProductUpdate(int $ID): void
    {
        if (isset($_POST['pbw'])) : 

            $product    = pbw_getProduct($ID);
            $data       = $_POST['pbw'];

            $active     = $data['active'] ? 1 : 0;
            $weight     = $active ? (int) $data['default_weight'] : 0;
            $step       = $active ? (int) $data['default_step_weight'] : 0;
            $showPrice  = $active ? sanitize_text_field($data['show_kg_price']) : 'inherit';
            $salesType  = $active ? sanitize_text_field($data['sales_type']) : 'inherit';

            $product->set('active', $active);
            $product->set('weight', $weight);
            $product->set('step_weight', $step);
            $product->set('show_kg_price', $showPrice);
            $product->set('sales_type', $salesType);

            $product->save();
        endif;
    }
}

ProductHooks::init();