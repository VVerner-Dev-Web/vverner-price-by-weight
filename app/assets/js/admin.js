jQuery(function ($) {
    const $controller = $('#pbw-active');
    const $form = $('#pbw-settings-table');

    $controller.change(handleControllerStatus)
    handleControllerStatus();

    function handleControllerStatus() {
        if ($controller.is(':checked')) {
            $form.show();
            $form.find('input, select').attr('required', true);
        } else {
            $form.find('input, select').val('');
            $form.hide();
            $form.find('input, select').attr('required', false);
        }
    }
});