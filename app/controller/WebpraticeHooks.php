<?php defined('ABSPATH') || exit('No direct script access allowed');

class WebpraticeHooks
{
   public static function init(): void
   {
      $handler = new self();
      add_action('tga_product_update', [$handler, 'updateProduct'], 99, 2);
      add_action('tga_order_item', [$handler, 'updateOrderItem'], 99, 2);
   }

   public function updateProduct(array $data, WC_Product $product): void
   {
      $weight  = (float) $data['PESOLIQUIDO'];
      if ($data['UNIDADE']  === 'KG' && $weight > 0) :
         $weight *= 1000;
         $product->add_meta_data('_pbw_active', 1, true);
         $product->add_meta_data('_pbw_weight', $weight, true);
         $product->add_meta_data('_pbw_weight_step', $weight, true);
      else :
         $product->add_meta_data('_pbw_active', 0, true);
         $product->add_meta_data('_pbw_weight', 0, true);
         $product->add_meta_data('_pbw_weight_step', 0, true); 
      endif;
   }

   public function updateOrderItem($data, $orderItem)
   {
      $method = $orderItem->get_meta('_pbw_method');
      if ($method) :
         $product = $orderItem->get_product();

         if ($method === 'und') :
            $weight  = (int) ($product->get_meta('_pbw_weight') * $orderItem->get_quantity());
            $unities = (int) $orderItem->get_quantity();
         else :
            $weight  = (int) $orderItem->get_quantity();
            $unities = (int) round($orderItem->get_quantity() / $product->get_meta('_pbw_weight'));
         endif;

         $data->quantidade = $weight / 1000;
         $data->campoLivre = $method === 'und' ? $unities . ' unidades' : '';
      endif;

      return $data;
   }
}


WebpraticeHooks::init();