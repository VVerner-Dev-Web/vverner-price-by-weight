<?php 

namespace PBW\WooCommerce;

defined('ABSPATH') || exit('No direct script access allowed');

class CheckoutHooks
{
    public static function init(): void
    {
        $handler = new self();
        add_action('woocommerce_checkout_cart_item_quantity',  [$handler, 'updateProductPriceOnCheckout'], 99, 2);
        add_action('woocommerce_checkout_create_order_line_item', [$handler, 'saveProductData'], 99, 4);
    }

    public function updateProductPriceOnCheckout(string $text, array $item): string
    {
        if (!$this->isCartItemSoldByWeight($item)) : 
            return $text;
        endif;

        $method = $item['pbw']['method'];
        $text  .= $method === 'weight' ? ' gramas'  : ' unidades';

        return $text;
    }

    public function saveProductData ($item, $cart_item_key, $values, $order) 
    {
        if ($this->isCartItemSoldByWeight( $values )) : 
            $method = $values['pbw']['method'];
            $method = $method === 'weight' ? 'Gramas'  : 'Unidades';
            $item->add_meta_data('Unidade de medida', $method, true);
        endif;
    }

    private function isCartItemSoldByWeight(array $item): bool
    {
        return isset($item['pbw']);
    }
}

CheckoutHooks::init();
