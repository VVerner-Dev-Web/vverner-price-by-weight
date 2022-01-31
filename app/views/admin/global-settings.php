<?php defined('ABSPATH') || exit('No direct script access allowed'); 

$app = pbw_getApp();

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], $_POST['action'])) : 
    $data = $_POST['pbw'];

    $app->set('default_weight', (int) $data['default_weight']);
    $app->set('default_step_weight', (int) $data['default_step_weight']);
    $app->set('show_kg_price', sanitize_text_field($data['show_kg_price']));
    $app->set('sales_type', sanitize_text_field($data['sales_type']));
endif;

?>

<h1>Configurações de preço por peso.</h1>
<p>Todas as configurações de peso utilizam a unidade de medida em <strong>gramas</strong>.</p>
<p>Todas os campo são de preenchimento obrigatório.</p>

<form method="POST">
    <?php $app->loadView('components/form-table-settings') ?>

    <input type="hidden" name="action" value="update_pbw_settings">
    <?php wp_nonce_field('update_pbw_settings'); ?>
    <button class="button">Salvar configurações</button>
</form>