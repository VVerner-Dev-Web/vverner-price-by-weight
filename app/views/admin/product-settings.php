<?php defined('ABSPATH') || exit('No direct script access allowed'); ?>

<div class="options_group">
    <?php

    $product = wc_get_product(get_the_ID());

    woocommerce_wp_checkbox([
            'id'                => 'pbw-active',
            'name'              => 'pbw[active]',
            'label'             => 'Utilizar preço por peso',
            'value'             => $product ? $product->get_meta('_pbw_active') : 0,
            'cbvalue'           => 1,
        ]
    );

    pbw_getApp()->loadView('components/form-table-settings');

    ?>
</div>