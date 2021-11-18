<?php defined('ABSPATH') || exit('No direct script access allowed');

$product = wc_get_product(get_the_ID());
if($product->get_meta('_pbw_weight')): ?>

   <div class="real-price-box" style="display: none">
      <p><strong>Total:</strong> <span class="real-price">---</span></p>
      <p><strong>Peso total:</strong> <span class="real-weight">---</span> gramas</p>
      <p><small>Os valores acima são estimativas, o valor real pode variar de acordo com o peso dos produtos selecionados</small></p>
   </div>

<?php endif;