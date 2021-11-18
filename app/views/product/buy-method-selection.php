<?php defined('ABSPATH') || exit('No direct script access allowed');
global $product;
if($product->get_meta('_pbw_weight')): ?>
   
   <?php $instance = uniqid('pbw_'); ?>

   <div class="pbw-instance" data-instance="<?= $instance ?>">
      <label>Comprar por:</label>
      <select name="pbw[method]" class="pbw-method">
         <option value="und">Unidade</option>
         <option value="kg">Peso</option>
      </select>

      <div class="real-price-box" style="display: none">

         <p class="mb-0">Peso médio por unidade: <?= $product->get_meta('_pbw_weight') ?>g</p>
         <p class="mb-0"><strong>Total:</strong> <span class="real-price">---</span></p>
         <p><strong>Peso total:</strong> <span class="real-weight">---</span> gramas</p>
         
         <p><small>Os valores acima são estimativas, o valor real pode variar de acordo com o peso dos produtos selecionados</small></p>
      </div>

      <script>
         var <?= $instance ?> = {
            'weight': <?= (float) $product->get_meta('_pbw_weight') ?>,
            'step'  : <?= (int) $product->get_meta('_pbw_weight_step') ?>,
            'price' : <?= (float) $product->get_price() ?>
         }
      </script>
   </div>

<?php endif;