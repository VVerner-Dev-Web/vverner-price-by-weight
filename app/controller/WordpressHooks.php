<?php defined('ABSPATH') || exit('No direct script access allowed');

class WordpressHooks
{
   public static function init(): void
   {
      $handler = new self();
      add_action('admin_enqueue_scripts', [$handler, 'adminEnqueueScripts']);
      add_action('wp_enqueue_scripts', [$handler, 'wpEnqueueScripts']);
   }

   public function adminEnqueueScripts(): void
   {
      if(get_post_type() === 'product'):
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
      if(is_singular('product')):
         $product = wc_get_product(get_the_ID());
         if($product->get_meta('_pbw_weight')):
            wp_enqueue_script(
               'pbw-product',
               plugins_url('/app/assets/js/single-product.min.js', PBW_FILE),
               ['jquery'],
               uniqid(),
               true
            );
            wp_localize_script('pbw-product', 'pbw', [
               'weight' => (float) $product->get_meta('_pbw_weight'),
               'price'  => (float) $product->get_price()
            ]);
         endif;
      endif;
   }
}

WordpressHooks::init();