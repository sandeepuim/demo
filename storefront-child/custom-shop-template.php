<?php
defined('ABSPATH') || exit;

get_header('shop');

// ✅ Open Storefront's main content wrappers
do_action('woocommerce_before_main_content');
?>

<div class="custom-shop-wrapper" style="padding: 0 15px; max-width: 1200px; margin: 0 auto;">
    <div class="ajax-search-wrapper" style="margin: 20px 0;">
        <input type="text" id="ajax-product-search" placeholder="🔍 Search for products..." style="width: 100%; padding: 10px; font-size: 16px;">
    </div>

    <div id="product-search-results">
        <?php
        woocommerce_product_loop_start();
        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();
                wc_get_template_part('content', 'product');
            }
        }
        woocommerce_product_loop_end();
        ?>
    </div>
</div>

<?php
// ✅ Close Storefront's main content wrappers
do_action('woocommerce_after_main_content');

get_footer('shop');
