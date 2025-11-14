<?php

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.5');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cyclon_theme_setup()
{
    /*
        * Make theme available for translation.

        */
    load_theme_textdomain('cyclon', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    // add_theme_support( 'automatic-feed-links' );

    /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
    add_theme_support('title-tag');

    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'primary-nav' => esc_html__('Primary', 'cyclon'),
            'mobile-nav' => esc_html__('Mobile', 'cyclon'),
            'copyright-nav' => esc_html__('Copyright Menu', 'cyclon')
        )
    );

    // CONCEPT MANIAX 

    // Remove Gutenberg editor
    add_filter('use_block_editor_for_post', '__return_false', 10);


    // MEGA MENU
    // function my_custom_menu_item_html($item_output, $item, $depth, $args)
    // {
    //     if ('primary-nav' === $args->theme_location && in_array('menu-item-has-children', $item->classes)) {


    //         ob_start();
    //         include(get_stylesheet_directory() . '/template-parts/header/mega-menu.php');
    //         $dropdown_html = ob_get_clean();

    //         $item_output .= '<ul class="sub-menu">' . $dropdown_html . '</ul>';
    //     }
    //     return $item_output;
    // }
    // add_filter('walker_nav_menu_start_el', 'my_custom_menu_item_html', 10, 4);


    /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}

add_action('after_setup_theme', 'cyclon_theme_setup');

//add_filter('wp_nav_menu_objects', 'my_menu_filter', 10, 2);
//function my_menu_filter($items, $args)
//{
//    if ($args->theme_location == "mobile-nav") {
//        $i = 0;
//        foreach ($items as $item) {
//            if ($i == 2):
//                $item->title = '<div id="end">' . $item->title .'</div><div class="mobileProducts" style="padding:30px 0;background: #efefef;">
//
//</div>';
//
//            endif;
//            $i++;
//        }
//    }
//    return $items;
//}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cyclon_theme_content_width()
{
    $GLOBALS['content_width'] = apply_filters('cyclon_theme_content_width', 640);
}

add_action('after_setup_theme', 'cyclon_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cyclon_theme_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'cyclon'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Footer 1 Top', 'cyclon'),
            'id' => 'footer-1-top',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Footer 2 Top', 'cyclon'),
            'id' => 'footer-2-top',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Footer 3 Top', 'cyclon'),
            'id' => 'footer-3-top',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Footer 4 Top', 'cyclon'),
            'id' => 'footer-4-top',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Footer 5 Top', 'cyclon'),
            'id' => 'footer-5-top',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Footer 1 Bottom', 'cyclon'),
            'id' => 'footer-1-bottom',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Footer 2 Bottom', 'cyclon'),
            'id' => 'footer-2-bottom',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Footer 3 Bottom', 'cyclon'),
            'id' => 'footer-3-bottom',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Footer 4 Bottom', 'cyclon'),
            'id' => 'footer-4-bottom',
            'description' => esc_html__('Add widgets here.', 'cyclon'),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="footer-widget-title">',
            'after_title' => '</h2>',
        )
    );
}

add_action('widgets_init', 'cyclon_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function cyclon_theme_scripts()
{
    wp_enqueue_style('fonts', get_template_directory_uri() . '/fonts/font-face.css', array(), _S_VERSION);
    wp_enqueue_style('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.css', array(), _S_VERSION, 'all');
    wp_enqueue_style('simpleScroll', 'https://cdn.jsdelivr.net/npm/simple-scrollbar@latest/simple-scrollbar.css', array(), _S_VERSION, 'all');
    //wp_enqueue_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), _S_VERSION, 'all');
    wp_enqueue_style('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), _S_VERSION, 'all');
    wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css', array(), _S_VERSION, 'all');
    wp_enqueue_style('cyclon-wp-theme-style', get_template_directory_uri() . '/sass/style.css', array(), time(), 'all');
    wp_enqueue_style('concept-style', get_template_directory_uri() . '/css/concept.css', array(), time(), 'all');

    if (is_tax('cyclon_product_cat')) {
        wp_enqueue_style('product-archive', get_stylesheet_directory_uri() . '/css/product-archive.css', array(), time(), 'all');
    }

    wp_style_add_data('cyclon-wp-theme-style', 'rtl', 'replace');

    wp_enqueue_script('cyclon-wp-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), _S_VERSION, true);

    //wp_register_script('gsap', get_stylesheet_directory_uri(). '/js/vendor/gsap/gsap.min.js', array(), '3.10.1', true);
    //wp_register_script('scroll-trigger', get_stylesheet_directory_uri(). '/js/vendor/gsap/ScrollTrigger.min.js', array('gsap'), '3.10.1', true);
    //wp_register_script('slick', get_stylesheet_directory_uri(). '/js/vendor/slick/slick.min.js', array(), '1.8.1', true);
    wp_register_script('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js', array(), '8.0.7', true);
    wp_register_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js', array('jquery'), '8.0.7', true);
    wp_register_script('simpleScroll', 'https://cdn.jsdelivr.net/npm/simple-scrollbar@latest/simple-scrollbar.min.js', array(), '5', true);
    wp_register_script('debounce', 'https://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js?ver=1.0.5', array(), '5', true);
    wp_register_script('cyclon', get_stylesheet_directory_uri() . '/js/cyclon.js', array('jquery'), time(), true);
    wp_localize_script('cyclon', 'wpAjax', array('ajaxUrl' => admin_url('admin-ajax.php')));

    wp_localize_script('cyclon', 'translateString', [
        'viewallproducts' => esc_html__('VIEW ALL PRODUCTS', 'cyclon'),
        'viewall' => esc_html__('VIEW ALL', 'cyclon'),
        'back' => esc_html__('back', 'cyclon'),
    ]);

    if (is_tax('cyclon_product_cat')) {
        wp_enqueue_script('product-archive', get_stylesheet_directory_uri() . '/js/productArchive.js', array('jquery'), time(), true);
    }

    wp_enqueue_script('swiper');
    wp_enqueue_script('simpleScroll');
    wp_enqueue_script('debounce');
    wp_enqueue_script('fancybox');
    wp_enqueue_script('cyclon');
}

add_action('wp_enqueue_scripts', 'cyclon_theme_scripts');

//add_filter('wp_nav_menu_items', 'cyclon_add_menu_item', 10, 2);
function cyclon_add_menu_item($items, $args)
{
    if ($args->theme_location == 'primary-nav')
        $items .= '<li class="menu-item">

<a href="#" class="iconLink__Link searchTrigger" style="vertical-align: middle;">
			<img src="' . get_template_directory_uri() . '/img/search.svg" class="img-responsive"/>
		</a>
</li>';
    return $items;
}

require_once(get_template_directory() . '/inc/post-types.php');

add_filter('facetwp_facet_dropdown_show_counts', '__return_false');

// Get single mapping information
add_action("wp_ajax_get_mapping_info", "get_mapping_info");
add_action("wp_ajax_nopriv_get_mapping_info", "get_mapping_info");

function get_mapping_info()
{

    if (!isset($_POST['req_nonce']) && !wp_verify_nonce($_POST['req_nonce'], "get_mapping_info_nonce")) {
        exit("Error!");
    }

    $indexRow = sanitize_text_field($_POST['indexRow']);
    $indexRowWrap = sanitize_text_field($_POST['indexRowWrap']);
    $pageID = sanitize_text_field($_POST['pageID']);
    $mapInfo = [];

    $rowsWrap = get_field('mapping_information', $pageID); // get all the rows
    $specific_row_Wrap = $rowsWrap[$indexRowWrap]; // 0 will get the first row, remember that the count starts at 0
    // if( have_rows('mapping_information', $pageID) ):
    //     while ( have_rows('mapping_information', $pageID) ) : the_row();
    //     if ($row == $indexRowWrap) {
    // $rows = get_sub_field('part_details' , $pageID);
    $specific_row = $specific_row_Wrap['part_details'][$indexRow];
    //     }
    //     $rows = $row;
    //     endwhile;
    // endif;

    // $specific_row = $rows[$indexRow]; // 0 will get the first row, remember that the count starts at 0

    $links = [];
    $cat = [];
    $oil_category_links = $specific_row['oil_category_product'];
    foreach ($oil_category_links as $oil_category_link) {
        $term = get_term($oil_category_link, 'cyclon_product_cat');
        $link = get_term_link($term);
        array_push($cat, $term->name);
        array_push($cat, $link);
        array_push($links, $cat);
        $cat = [];
    }

    $mapInfo['part_title_front'] = $specific_row['part_title_front'];
    $mapInfo['part_image'] = $specific_row['part_image'];
    $mapInfo['oil_image'] = $specific_row['oil_image'];
    $mapInfo['oil_title'] = $specific_row['oil_title'];
    $mapInfo['oil_category_link'] = $links;


    wp_send_json($mapInfo);
}


function cyclon_show_blogposts()
{
    $selected = $_POST['catID'];

    ob_start(); ?>

    <div class="blogWrapper__Inner">
        <div class="container">
            <div class="row">
                <?php

                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 16,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $selected
                        )
                    )
                );
                $bQ = new WP_Query($args);

                if ($bQ->have_posts()):
                    while ($bQ->have_posts()): $bQ->the_post(); ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                            <div class="blogCard">
                                <div class="blogCard__Image">
                                    <?php if (has_post_thumbnail()):
                                        the_post_thumbnail('full', array('img-fluid'));
                                    endif; ?>
                                </div>
                                <div class="blogCard__Date">
                                    <?php echo get_the_time(get_option('date_format')); ?>
                                </div>
                                <div class="blogCard__Content">
                                    <h3><?php the_title(); ?></h3>
                                    <?php if (get_field('excerpt')): ?>
                                        <p>
                                            <?php echo get_field('excerpt'); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <svg class="blogCard__ReadMoreArrow" xmlns="http://www.w3.org/2000/svg"
                                    width="39.863" height="21.08" viewBox="0 0 39.863 21.08">
                                    <g id="Group_11879" data-name="Group 11879"
                                        transform="translate(-1321.05 -1554.851)">
                                        <path id="Path_23608" data-name="Path 23608"
                                            d="M-3854.35-12978.5h38.363"
                                            transform="translate(5176.15 14543.697)" fill="none"
                                            stroke="#042759" stroke-linecap="round" stroke-width="1.5" />
                                        <path id="Path_23609" data-name="Path 23609"
                                            d="M-3744.65-13022.2l9.479,9.479-9.479,9.48"
                                            transform="translate(5095.144 14578.112)" fill="none"
                                            stroke="#042759" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.5" />
                                    </g>
                                </svg>
                                <a href="<?php the_permalink(); ?>" class="blogCard__ReadMore"></a>
                            </div>
                        </div>
                <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php

    // Save output and stop output buffering
    $output = ob_get_clean();
    $html = $output;

    echo json_encode(
        array(
            'html' => $html,
            'selCat' => $selected,
            'success' => 1
        )
    );
    die();
}

add_action('wp_ajax_nopriv_cyclon_show_blogposts', 'cyclon_show_blogposts');
add_action('wp_ajax_cyclon_show_blogposts', 'cyclon_show_blogposts');


add_filter('xmlrpc_enabled', '__return_false');

add_filter('get_terms_args', function ($args, $taxonomies) {
    if (isset($args['term_order']) && 'order' !== $args['meta_key']) { // The second condition is needed to preserve WooCommerce ordering for product categories, by a termmeta field named "order".
        $args['orderby'] = 'term_order';
    }
    return $args;
}, 10, 2);

add_filter('get_terms_orderby', function ($orderby, $query_vars, $taxonomies) {
    return 'term_order' === $query_vars['orderby'] ? 'term_order' : $orderby;
}, 10, 3);



//
function fragmet_url_redirect()
{
    echo '<script>
function locationHashChanged() {
    if (location.hash === "#filter=lava") {
        window.location.replace("https://www.cyclon-lpc.com/el/motorcycle-lubricants/");
    }
    else if (location.hash === "#filter=magma") {
        window.location.replace("https://www.cyclon-lpc.com/el/passenger-car-lubricants/");
    }
    else if (location.hash === "#filter=granit") {
        window.location.replace("https://www.cyclon-lpc.com/el/heavy-duty-lubricants/");
    }
    else if (location.hash === "#filter=marine") {
        window.location.replace("https://www.cyclon-lpc.com/el/marine-lubricants/");
        //console.log (window.location.pathname + window.location.hash);
    }
    else if (location.hash === "#filter=industrial") {
        window.location.replace("https://www.cyclon-lpc.com/el/marine-lubricants/");
    }
    //
    // else if ((window.location.pathname + window.location.hash) === "en/products/lubricants/#filter=marine") {
    //     window.location.replace("https://www.cyclon-lpc.com/marine-lubricants/");
    // }
}
locationHashChanged();
// window.onhashchange = locationHashChanged;
</script>';
}
add_action('wp_footer', 'fragmet_url_redirect');

#Disable REST API
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('template_redirect', 'rest_output_link_header', 11);
