<?php
include ABSPATH . "../../vendor/autoload.php";

use Commerce\Config\AutoLoader;
use Commerce\Config\View;
use Commerce\Config\Woocommerce;
use Commerce\Config\CustomPostTypes;
use Commerce\Config\CustomTaxonomies;

use Commerce\Controller\VariationMetaBox;
use Commerce\Controller\WooMetaCart;

/*
 * Set up our auto loading class and mapping our namespace to the app directory.
 *
 * The autoloader follows PSR4 autoloading standards so, provided StudlyCaps are used for class, file, and directory
 * names, any class placed within the app directory will be autoloaded.
 *
 * i.e; If a class named SomeClass is stored in app/SomeDir/SomeClass.php, there is no need to include/require that file
 * as the autoloader will handle that for you.
 */
require get_stylesheet_directory() . '/app/Config/AutoLoader.php';
$loader = new AutoLoader();
$loader->register();
$loader->addNamespace( 'Commerce', get_stylesheet_directory() . '/app' );

View::$view_dir = get_stylesheet_directory() . '/templates/views';

require get_stylesheet_directory() . '/includes/scripts-and-styles.php';

new Woocommerce();

CustomPostTypes::register();
CustomTaxonomies::register();

new VariationMetaBox();
new WooMetaCart();
