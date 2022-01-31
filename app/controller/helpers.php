<?php defined('ABSPATH') || exit('No direct script access allowed');

function pbw_getApp(): \PBW\App
{
    return new PBW\App();
}

function pbw_getProduct(int $product_ID): \PBW\Product
{
    return new PBW\Product( $product_ID );
}