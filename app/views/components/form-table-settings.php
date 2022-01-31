<?php

$app = pbw_getApp(); 
$env = get_the_ID() ? 'product' : 'settings';
$product = $env === 'product' ? pbw_getProduct(get_the_ID()) : null;
?>
<table class="form-table form-<?= $env ?>" id="pbw-settings-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="pbw-default_weight">
                    Peso médio padrão
                </label>
            </th>
            <td>
                <input  type="number" value="<?= $product ? $product->get('weight') : $app->get('default_weight') ?>" 
                        name="pbw[default_weight]" id="pbw-default_weight" 
                        class="regular-text" min="0" step="1" >
                <?php if ($product) : ?>
                    <small class="input-legend">Informe o valor "0" para herdar das configurações globais</small>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pbw-default_step_weight">
                    Step padrão para compras em peso
                </label>
            </th>
            <td>
                <input  type="number" value="<?= $product ? $product->get('step_weight') :  $app->get('default_step_weight') ?>" 
                        name="pbw[default_step_weight]" id="pbw-default_step_weight" 
                        class="regular-text" min="0" step="1" >
                <?php if ($product) : ?>
                    <small class="input-legend">Informe o valor "0" para herdar das configurações globais</small>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pbw-show_kg_price">
                    Exibir o preço do kg?
                </label>
            </th>
            <td>
                <?php $current = $product ? $product->get('show_kg_price') :  $app->get('show_kg_price') ?>
                <select name="pbw[show_kg_price]" id="pbw-show_kg_price" class="regular-text" required>
                    <option value="" hidden>Selecione</option>
                    <?php if ($product) : ?>
                        <option <?php selected('inherit', $current) ?> value="inherit">Herdar das configurações globais</option>
                    <?php endif; ?>
                    <option <?php selected('yes', $current) ?> value="yes">
                        Exibir o preço do kg
                    </option>
                    <option <?php selected('no', $current) ?> value="no">
                        Não exibir o preço do kg
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pbw-sales_type">
                    Formato de vendas
                </label>
            </th>
            <td>
                <?php $current = $product ? $product->get('sales_type') :  $app->get('sales_type') ?>
                <select name="pbw[sales_type]" id="pbw-sales_type" class="regular-text" required>
                    <option value="" hidden>Selecione</option>
                    <?php if ($product) : ?>
                        <option <?php selected('inherit', $current) ?> value="inherit">Herdar das configurações globais</option>
                    <?php endif; ?>
                    <option <?php selected('weight', $current) ?> value="weight">
                        Permitir compra apenas por peso
                    </option>
                    <option <?php selected('quantity', $current) ?> value="quantity">
                        Permitir compra apenas por unidade
                    </option>
                    <option <?php selected('both', $current) ?> value="both">
                        Permitir compra por peso e unidade
                    </option>
                </select>
            </td>
        </tr>
    </tbody>
</table>