<?php defined('ABSPATH') || exit('No direct script access allowed');

class WoocommerceHooks
{
   public static function init(): void
   {
      $handler = new self();

      // ADMIN - PRODUCT
      add_action('woocommerce_product_options_general_product_data', [$handler, 'enqueueProductFields']);
      add_action('woocommerce_process_product_meta', [$handler, 'handleProductUpdate'], 99, 2);

      // CART
      add_action('woocommerce_before_calculate_totals',  [$handler, 'updateProductPricesOnCart'], 99);
      add_action('woocommerce_cart_item_price', [$handler, 'updateCartItemPrice'], 99, 2);
      add_action('woocommerce_cart_item_quantity', [$handler, 'updateCartItemQuantity'], 99, 3);

      // VIEW
      add_filter( 'woocommerce_get_price_html', [$handler, 'appendPriceDescription'], 99, 2);
      add_action( 'woocommerce_before_add_to_cart_form', [$handler, 'appendRealPriceBox']);
   }

   public function enqueueProductFields(): void
   {
      require_once PBW_VIEWS . '/product/settings.php';
   }

   public function handleProductUpdate($id, $post): void
   {
      if (!isset($_POST['pbw'])) return;
      $data    = $_POST['pbw'];
      $product = wc_get_product($id);

      if($product):
         $active = $data['active'] ? 1 : 0;
         $weight = $active ? (float) $data['weight'] : 0;

         error_log($active);
         error_log($weight);

         $product->add_meta_data('_pbw_active', $active, true);
         $product->add_meta_data('_pbw_weight', $weight, true);

         $product->save();
      endif;
   }

   public function appendPriceDescription($price, $product): string
   {
      if($product->get_meta('_pbw_weight')):
         $price .= ' preço por quilo. Peso médio por unidade: ' . $product->get_meta('_pbw_weight') . ' gramas';
      endif;

      return $price;
   }

   public function appendRealPriceBox(): void
   {
      require PBW_VIEWS . '/product/real-price-box.php';
   }

   public function updateProductPricesOnCart($cart): void
   {
      if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

      foreach($cart->get_cart() as $item):
         $product = wc_get_product($item['product_id']);
         $weight  = $product->get_meta('_pbw_weight');

         if($weight):
            $price = ($weight / 1000) * $product->get_price();
            $item['data']->set_price( $price );
         endif;

      endforeach;
   }

   public function updateCartItemPrice($price, $item): string
   {
      $product = wc_get_product($item['product_id']);
      return wc_price($product->get_price()) . ' /quilo';
   }

   public function updateCartItemQuantity($quantity, $itemKey, $item): string
   {
      $product = wc_get_product($item['product_id']);
      $weight  = $product->get_meta('_pbw_weight');

      if($weight):
         $weight = $weight * $item['quantity'];
         $quantity .= ' aprox. ' . round($weight) . ' gramas';
      endif;

      return $quantity;
   }
}

WoocommerceHooks::init();