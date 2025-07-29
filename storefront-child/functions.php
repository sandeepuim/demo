<?php
function my_child_theme_enqueue_styles() {
    $parent_style = 'storefront-style'; // This is the handle used by Storefront

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'my_child_theme_enqueue_styles' );

// ✅ Load parent and child styles
add_action('wp_enqueue_scripts', 'storefront_child_enqueue_styles');
function storefront_child_enqueue_styles() {
    wp_enqueue_style('storefront-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('storefront-child-style', get_stylesheet_directory_uri() . '/style.css', array('storefront-style'));
}

// ✅ Load AJAX JS
add_action('wp_enqueue_scripts', 'custom_ajax_search_enqueue');
function custom_ajax_search_enqueue() {
    wp_enqueue_script(
        'custom-search',
        get_stylesheet_directory_uri() . '/js/custom-search.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('custom-search', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

// ✅ AJAX handler
add_action('wp_ajax_ajax_product_search', 'ajax_product_search');
add_action('wp_ajax_nopriv_ajax_product_search', 'ajax_product_search');

function ajax_product_search() {
    $term = sanitize_text_field($_POST['term']);
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        's'              => $term,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="products columns-4">';
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        echo '</ul>';
    } else {
        echo '<p>No products found</p>';
    }

    wp_die();
}

// ✅ Override Shop page and inject AJAX search
 

// ✅ Our AJAX search UI and product loop
function storefront_render_ajax_search_section() {
    ?>
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
    <?php
}
 
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
