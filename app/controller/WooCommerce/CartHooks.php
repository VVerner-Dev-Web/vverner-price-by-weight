<?php 

namespace PBW\WooCommerce;

defined('ABSPATH') || exit('No direct script access allowed');

class CartHooks
{
    public static function init(): void
    {
        $handler = new self();
        add_action('woocommerce_before_calculate_totals',  [$handler, 'updateProductPricesOnCart'], 99);
        add_action('woocommerce_cart_item_price', [$handler, 'updateCartItemPrice'], 99, 2);
        add_action('woocommerce_cart_item_quantity', [$handler, 'updateCartItemQuantity'], 99, 3);
        add_filter('woocommerce_add_cart_item_data', [$handler, 'saveCartItemData'], 99);
    }

    public function saveCartItemData(array $item): array
    {
        if (isset($_REQUEST['pbw_method'])) : 
            $item['pbw'] = [
                'method' => sanitize_text_field($_REQUEST['pbw_method'])
            ];
        endif;

        return $item;
    }

    public function updateProductPricesOnCart($cart): void
    {
        if (is_admin() && !defined('DOING_AJAX')) return;

        foreach ($cart->get_cart() as $item) :
            if (!$this->isCartItemSoldByWeight($item)) : 
                continue;
            endif;

            $method         = $item['pbw']['method'];
            $product        = pbw_getProduct($item['product_id']);
            $price          = $product->getPrice() / 1000;

            if ($method === 'quantity') :
                $price *= $product->getWeightStep();
            endif;

            $item['data']->set_price($price);
        endforeach;
    }

    public function updateCartItemPrice($price, $item): string
    {
        $product = pbw_getProduct($item['product_id']);

        if ($product->isActive()) :
            $price = $product->isKgPriceVisible() ? wc_price($product->getPrice()) . '/kg' : '---';
        endif;

        return $price;
    }

    public function updateCartItemQuantity($quantity, $itemKey, $item): string
    {
        if (!$this->isCartItemSoldByWeight($item)) : 
            return $quantity;
        endif;

        $method         = $item['pbw']['method'];
        $product        = pbw_getProduct($item['product_id']);
        $requested      = $item['quantity'];
        $weight         = $product->getWeight();
        $totalWeight    = $requested * $weight;
        $totalCount     = $requested / $weight;

        if ($method === 'weight') : 
            $quantity   =  $totalCount . ' unidades, <br> aprox. ' . $requested . ' gramas';

        elseif ($method === 'quantity') : 
            $quantity   =  $requested . ' unidades, <br> aprox. ' . $totalWeight . ' gramas';

        endif;

        return $quantity;
    }

    private function isCartItemSoldByWeight(array $item): bool
    {
        return isset($item['pbw']);
    }
}

CartHooks::init();
