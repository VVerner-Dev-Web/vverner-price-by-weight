<?php defined('ABSPATH') || exit('No direct script access allowed');

$product = pbw_getProduct(get_the_ID());

if ($product->isActive()) :
    $salesType = $product->getSalesType();
    ?>

    <div class="pbw-instance" data-env='<?= $product->getJsonSettings() ?>'>
        <?php if ($salesType === 'both') : ?>
            <div class="selector">
                <label>Comprar por:</label>
                <select name="pbw_method" class="pbw-method">
                    <option value="weight">Peso</option>
                    <option value="quantity">Unidade</option>
                </select>
            </div>

        <?php else: ?>
            <input type="hidden" name="pbw_method" class="pbw-method" value="<?= $salesType === 'weight' ? 'kg' : 'und' ?>">

        <?php endif; ?>

        <div class="real-price-box" style="display: none">
            <p class="mb-0">Peso médio por unidade: <?= $product->getWeight() ?>g</p>
            <p><strong>Quantidade:</strong> <span class="real-quantity">---</span></p>
            <p><strong>Peso total:</strong> <span class="real-weight">---</span> gramas</p>
            <p class="mb-0"><strong>Total a pagar:</strong> <span class="real-price">---</span></p>


            <p><small>Os valores acima são estimativas, o valor real pode variar de acordo com o peso dos produtos selecionados</small></p>
        </div>
    </div>

<?php endif;
