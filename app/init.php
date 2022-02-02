<?php defined('ABSPATH') || exit('No direct script access allowed');

require_once PBW_APP . '/controller/helpers.php';
require_once PBW_APP . '/controller/App.php';
require_once PBW_APP . '/controller/Product.php';

require_once PBW_APP . '/controller/Webpratice/TgaHooks.php';

require_once PBW_APP . '/controller/WooCommerce/ProductHooks.php';
require_once PBW_APP . '/controller/WooCommerce/CartHooks.php';
require_once PBW_APP . '/controller/WooCommerce/CheckoutHooks.php';
require_once PBW_APP . '/controller/WooCommerce/FrontendHooks.php';

require_once PBW_APP . '/controller/WordPress/AssetsHooks.php';
require_once PBW_APP . '/controller/WordPress/SettingsHooks.php';