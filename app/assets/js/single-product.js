jQuery(function($){
   const ENV = pbw;
   
   const $container        = $('.real-price-box');
   const $quantityInput    = $('.qty');

   updatePriceBox();
   $quantityInput.change(updatePriceBox);

   function getPrice(weight){
      return ENV.price * weight;
   }

   function getTotalWeight(qty) {
      return ENV.weight * qty / 1000;
   }

   function updatePriceBox() {
      const weight = getTotalWeight( $quantityInput.val() );
      const price = getPrice( weight );

      if(price > 0) {
         $container.show();
      } else {
         $container.hide();
      }

      $container.find('.real-price').text(price.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}))
      $container.find('.real-weight').text(weight * 1000)
   }
})