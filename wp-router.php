
<?php
/**
 * package Name: wp-routre 
 * package URI: https://github.com/mshossain110/wp-router
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require __DIR__.'/src/Traits/Singletonable.php';
require __DIR__.'/src/Router.php';
require __DIR__.'/src/Uri_Parser.php';
require __DIR__.'/src/WP_Router.php';