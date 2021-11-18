jQuery(function($){
   const $controller = $('#pbw-active');
   const $input      = $('#pbw-weight');

   $controller.change(handleControllerStatus)
   handleControllerStatus();

   function handleControllerStatus() {
      if($controller.is(':checked')) {
         $input.attr('required', true);
         $input.parents('.pbw-weight_field').show();
      } else {
         $input.val('');
         $input.attr('required', false);
         $input.parents('.pbw-weight_field').hide();
      }
   }
});