<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );
?>

<!-- ✅ Custom Search Box -->
<div class="ajax-search-wrapper" style="margin: 20px 0;">
    <input type="text" id="ajax-product-search" placeholder="🔍 Search for products..." style="width: 100%; padding: 10px; font-size: 16px;">
</div>

<!-- ✅ Default WooCommerce Product Loop Container -->
<div id="product-search-results">
    <?php
    if ( woocommerce_product_loop() ) {

        do_action( 'woocommerce_before_shop_loop' );

        woocommerce_product_loop_start();

        if ( wc_get_loop_prop( 'total' ) ) {
            while ( have_posts() ) {
                the_post();

                do_action( 'woocommerce_shop_loop' );
                wc_get_template_part( 'content', 'product' );
            }
        }

        woocommerce_product_loop_end();

        do_action( 'woocommerce_after_shop_loop' );

    } else {
        do_action( 'woocommerce_no_products_found' );
    }
    ?>
</div>

<?php
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
