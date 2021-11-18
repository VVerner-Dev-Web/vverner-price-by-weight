<?php defined('ABSPATH') || exit('No direct script access allowed'); ?>

<div class="options_group">
   <?php 
      $product = wc_get_product(get_the_ID());

      woocommerce_wp_checkbox([
         'id'		      => 'pbw-active',
         'name'	      => 'pbw[active]',
         'label'        => 'Utilizar preço por peso',
         'value'        => $product ? $product->get_meta('_pbw_active') : 0,
         'cbvalue'      => 1,
      ]);

      woocommerce_wp_text_input([
         'id'		      => 'pbw-weight',
         'name'	      => 'pbw[weight]',
         'label'        => 'Peso médio (g) de cada unidade',
         'type'         => 'number',
         'desc_tip'     => false,
         'value'        => $product ? $product->get_meta('_pbw_weight') : 0,
         'desc_tip'     => true,
         'description'  => 'Peso em gramas',
         'custom_attributes' => [
            'step'=> 1
         ]
      ]);
   ?> 
</div>