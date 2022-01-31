jQuery(function ($) {
    const $container = $('.real-price-box');
    const $quantityInput = $('.qty');
    const ENV = $('.pbw-instance').data('env');
    const $saleTypeController = $('.pbw-method');

    const Product = {
        getQuantity: () => {
            if (Controller.isSaleByWeight()) {
                return Math.round( $quantityInput.val() / ENV.weight );
            } else {
                return parseInt( $quantityInput.val() )
            }
        },
        getTotalWeight : () => ENV.weight * Product.getQuantity(),
        getPrice: () => Controller.convertToKg( Product.getTotalWeight() ) * ENV.price
    }

    const View = {
        updatePriceBox: () => {
            const price = Product.getPrice();
    
            if (price > 0) {
                $container.show();
            } else {
                $container.hide();
            }
    
            $container.find('.real-price').text(price.toLocaleString('pt-br', {
                style: 'currency',
                currency: 'BRL'
            }));

            $container.find('.real-weight').text(Product.getTotalWeight());
            $container.find('.real-quantity').text(Product.getQuantity());
        },
        updateQuantityInput: () => {
            if (Controller.isSaleByWeight()) {
                $quantityInput.attr('step', ENV.step).attr('min', ENV.step);
                $quantityInput.val(ENV.step);
            } else {
                $quantityInput.attr('step', 1).attr('min', 1);
                $quantityInput.val(1);
            }

            $quantityInput.trigger('change');
        }
    }

    const Controller = {
        convertToKg: weight => weight / 1000,
        isSaleByWeight: () => $saleTypeController.val() === 'weight'
    }

    View.updateQuantityInput();
    View.updatePriceBox();
    $quantityInput.on('change', View.updatePriceBox);
    $saleTypeController.on('change', View.updateQuantityInput);
})