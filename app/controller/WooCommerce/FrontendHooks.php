<?php 

namespace PBW\WooCommerce;

defined('ABSPATH') || exit('No direct script access allowed');

class FrontendHooks
{
    public static function init(): void
    {
        $handler = new self();
        add_filter('woocommerce_get_price_html', [$handler, 'appendPriceDescription'], 99, 2);
        add_action('woocommerce_after_add_to_cart_quantity', [$handler, 'appendRealPriceBox']);
    }

    public function appendPriceDescription($price, $_product): string
    {
        $product = pbw_getProduct($_product->get_id());
        if ($product->isKgPriceVisible()) :
            $price .= ' preço por quilo.';
            $price .= ' Peso médio: ' . $product->getWeight() . ' gramas';

        else :
            $price = '';
        endif;

        return $price;
    }

    public function appendRealPriceBox(): void
    {
        pbw_getApp()->loadView('product/real-price-box');
    }
}

FrontendHooks::init();
