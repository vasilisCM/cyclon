<?php

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.5');
}

// API Modules
include_once(get_template_directory() . '/api/filter-products.php');

function cyclon_limit_product_archive_posts($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_tax('cyclon_product_cat')) {
        $query->set('posts_per_page', -1);
    }

    if ($query->is_tax('cyclon_new_product_cat')) {
        // Get ALL posts first, we'll handle pagination after sorting
        $query->set('posts_per_page', -1);
        $query->set('nopaging', true);
        // Mark this query for custom sorting
        $query->set('cyclon_needs_range_sort', true);
        // Store the desired posts per page for later
        $query->set('cyclon_per_page', 8);

        // Apply URL filter params (e.g. ?cyclon_product_grade=5w-30) so pagination page 2+ keeps filters on full reload
        $filter_taxonomies = array(
            'cyclon_range',
            'cyclon_product_grade',
            'cyclon_product_type',
            'cyclon_new_product_acea',
            'cyclon_new_product_oem',
            'cyclon_specifications',
            'cyclon_new_product_cat',
        );
        $has_get_filters = false;
        foreach ($filter_taxonomies as $taxonomy) {
            if (!empty($_GET[$taxonomy]) && is_string($_GET[$taxonomy])) {
                $has_get_filters = true;
                break;
            }
        }
        if ($has_get_filters) {
            $tax_query = $query->get('tax_query');
            if (!is_array($tax_query) || empty($tax_query)) {
                $term = get_queried_object();
                if (!$term || !isset($term->term_id)) {
                    return;
                }
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'cyclon_new_product_cat',
                        'field'    => 'term_id',
                        'terms'    => array($term->term_id),
                    ),
                );
            }
            if (empty($tax_query['relation'])) {
                $tax_query['relation'] = 'AND';
            }
            foreach ($filter_taxonomies as $taxonomy) {
                if (!empty($_GET[$taxonomy]) && is_string($_GET[$taxonomy])) {
                    $terms = array_map('trim', explode(',', sanitize_text_field(wp_unslash($_GET[$taxonomy]))));
                    $terms = array_filter($terms);
                    if (!empty($terms)) {
                        $tax_query[] = array(
                            'taxonomy' => $taxonomy,
                            'field'    => 'slug',
                            'terms'    => $terms,
                            'operator' => 'IN',
                        );
                    }
                }
            }
            $query->set('tax_query', $tax_query);
        }
    }
}

add_action('pre_get_posts', 'cyclon_limit_product_archive_posts');

// Apply custom sorting to the main query on archive pages
function cyclon_sort_archive_posts($posts, $query)
{
    // Debug log
    error_log('🔍 cyclon_sort_archive_posts called. Posts count: ' . count($posts));
    error_log('🔍 Is main query: ' . ($query->is_main_query() ? 'YES' : 'NO'));
    error_log('🔍 Needs range sort flag: ' . ($query->get('cyclon_needs_range_sort') ? 'YES' : 'NO'));

    // Only sort if this is the main query that needs range sorting
    if (!$query->get('cyclon_needs_range_sort') || !$query->is_main_query()) {
        error_log('🔍 SKIPPING sort (flag or main query check failed)');
        return $posts;
    }

    error_log('🔍 APPLYING sort to ' . count($posts) . ' posts');

    if (function_exists('cyclon_sort_posts_by_range')) {
        $sorted = cyclon_sort_posts_by_range($posts);
        error_log('🔍 Sort completed. Result count: ' . count($sorted));

        // Now manually paginate the sorted results
        $per_page = $query->get('cyclon_per_page');
        if ($per_page) {
            $paged = max(1, get_query_var('paged'));
            $total = count($sorted);
            $offset = ($paged - 1) * $per_page;

            error_log('🔍 Paginating: page=' . $paged . ', per_page=' . $per_page . ', offset=' . $offset . ', total=' . $total);

            // Update query vars for pagination
            $query->found_posts = $total;
            $query->max_num_pages = ceil($total / $per_page);

            // Slice the sorted posts for this page
            $sorted = array_slice($sorted, $offset, $per_page);
            error_log('🔍 After pagination: ' . count($sorted) . ' posts');
        }

        return $sorted;
    }

    error_log('🔍 Sort function not found!');
    return $posts;
}

add_filter('the_posts', 'cyclon_sort_archive_posts', 10, 2);

// Search: for cyclon_new_product posts match title + taxonomy terms only (not content/excerpt).
// For all other post types keep default title + content + excerpt behaviour.
function cyclon_search_taxonomy_join($join)
{
    global $wpdb;
    if (!is_search() || is_admin()) return $join;

    $join .= " LEFT JOIN {$wpdb->term_relationships} AS ctr ON ({$wpdb->posts}.ID = ctr.object_id)
               LEFT JOIN {$wpdb->term_taxonomy} AS ctt ON (ctr.term_taxonomy_id = ctt.term_taxonomy_id AND ctt.taxonomy IN ('cyclon_range','cyclon_product_grade'))
               LEFT JOIN {$wpdb->terms} AS ct ON (ctt.term_id = ct.term_id) ";
    return $join;
}
add_filter('posts_join', 'cyclon_search_taxonomy_join');

function cyclon_search_taxonomy_where($search, $query)
{
    global $wpdb;
    if (!$query->is_search() || is_admin() || empty($search)) return $search;

    $terms = $query->get('search_terms');
    if (empty($terms)) return $search;

    $new_product_clauses = array();
    $other_clauses        = array();

    foreach ($terms as $term) {
        $like = '%' . $wpdb->esc_like($term) . '%';

        // cyclon_new_product: title OR taxonomy term name only
        $new_product_clauses[] = $wpdb->prepare(
            "( {$wpdb->posts}.post_type = 'cyclon_new_product' AND ({$wpdb->posts}.post_title LIKE %s OR ct.name LIKE %s) )",
            $like,
            $like
        );

        // all other post types: title only
        $other_clauses[] = $wpdb->prepare(
            "( {$wpdb->posts}.post_type != 'cyclon_new_product' AND {$wpdb->posts}.post_title LIKE %s )",
            $like
        );
    }

    // AND between terms (same strictness as WP default)
    $search = ' AND ( (' . implode(' AND ', $new_product_clauses) . ') OR (' . implode(' AND ', $other_clauses) . ') ) ';
    return $search;
}
add_filter('posts_search', 'cyclon_search_taxonomy_where', 10, 2);

function cyclon_search_taxonomy_distinct($distinct)
{
    if (is_search() && !is_admin()) return 'DISTINCT';
    return $distinct;
}
add_filter('posts_distinct', 'cyclon_search_taxonomy_distinct');

// // Improve search to use OR logic instead of AND (more user-friendly)
// function cyclon_search_or_logic($search, $query)
// {
//     global $wpdb;

//     if (!$query->is_search() || is_admin()) {
//         return $search;
//     }

//     // Get search terms
//     $search_terms = $query->get('search_terms');
//     if (empty($search_terms)) {
//         return $search;
//     }

//     // Build OR search query
//     $search = '';
//     $searchand = '';

//     foreach ($search_terms as $term) {
//         $term = $wpdb->esc_like($term);
//         $term = '%' . $term . '%';
//         $search .= "{$searchand}(({$wpdb->posts}.post_title LIKE '{$term}') OR ({$wpdb->posts}.post_content LIKE '{$term}'))";
//         $searchand = ' OR ';
//     }

//     if (!empty($search)) {
//         $search = " AND ({$search}) ";
//     }

//     return $search;
// }

// add_filter('posts_search', 'cyclon_search_or_logic', 500, 2);

// // Order search results by relevance (most matching words first)
// function cyclon_search_orderby_relevance($orderby, $query)
// {
//     global $wpdb;

//     if (!$query->is_search() || is_admin()) {
//         return $orderby;
//     }

//     $search_terms = $query->get('search_terms');
//     if (empty($search_terms)) {
//         return $orderby;
//     }

//     // Calculate relevance score
//     $relevance = '';
//     foreach ($search_terms as $term) {
//         $term = $wpdb->esc_like($term);
//         $term = '%' . $term . '%';
//         $relevance .= "+ (CASE WHEN {$wpdb->posts}.post_title LIKE '{$term}' THEN 2 ELSE 0 END)";
//         $relevance .= "+ (CASE WHEN {$wpdb->posts}.post_content LIKE '{$term}' THEN 1 ELSE 0 END)";
//     }

//     $orderby = "({$relevance}) DESC, {$wpdb->posts}.post_date DESC";

//     return $orderby;
// }

// add_filter('posts_orderby', 'cyclon_search_orderby_relevance', 500, 2);

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

    // CSS per page template
    // Home
    if (is_front_page()) {
        wp_enqueue_style('home-style', get_template_directory_uri() . '/css/home.css', array(), time(), 'all');
    }

    // New Product Category Archive
    if (is_tax('cyclon_new_product_cat')) {
        wp_enqueue_style('new-product-archive', get_stylesheet_directory_uri() . '/css/new-product-archive.css', array(), time(), 'all');
        wp_enqueue_style('new-product-card', get_stylesheet_directory_uri() . '/css/new-product-card.css', array(), time(), 'all');
    }

    // New Product Landing
    if (is_page_template('page-templates/cyclon-new-category-landing-tpl.php')) {
        wp_enqueue_style('new-product-landing', get_stylesheet_directory_uri() . '/css/new-product-landing.css', array(), time(), 'all');
        wp_enqueue_style('new-product-card', get_stylesheet_directory_uri() . '/css/new-product-card.css', array(), time(), 'all');
    }

    // New Product Single
    if (is_singular('cyclon_new_product')) {
        wp_enqueue_style('new-product-single', get_stylesheet_directory_uri() . '/css/single-product-new.css', array(), time(), 'all');
        wp_enqueue_style('new-product-card', get_stylesheet_directory_uri() . '/css/new-product-card.css', array(), time(), 'all');
        wp_enqueue_style('new-product-landing', get_stylesheet_directory_uri() . '/css/new-product-landing.css', array(), time(), 'all');
        wp_enqueue_script('new-product-single', get_stylesheet_directory_uri() . '/js/newSingleProduct.js', array('jquery'), time(), true);
    }

    wp_enqueue_script('gsap', get_template_directory_uri() . '/js/lib/gsap.min.js', array(), false, true);
    wp_enqueue_script('ScrollTrigger', get_template_directory_uri() . '/js/lib/ScrollTrigger.min.js', array(), false, true);

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
        'viewproducts' => esc_html__('VIEW PRODUCTS', 'cyclon'),
        'viewall' => esc_html__('VIEW ALL', 'cyclon'),
        'back' => esc_html__('back', 'cyclon'),
    ]);

    if (is_tax('cyclon_new_product_cat')) {
        wp_enqueue_script('new-product-archive', get_stylesheet_directory_uri() . '/js/newProductArchive.js', array('jquery'), time(), true);
        $current_lang = '';
        if (function_exists('apply_filters')) {
            $current_lang = apply_filters('wpml_current_language', null);
        }
        if ($current_lang === null) {
            $current_lang = '';
        }
        wp_localize_script('new-product-archive', 'wpAjax', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'currentLang' => $current_lang,
        ));
        wp_localize_script('new-product-archive', 'cyclonFilters', array(
            'taxonomies' => array(
                'cyclon_range',
                'cyclon_product_grade',
                'cyclon_product_type',
                'cyclon_new_product_acea',
                'cyclon_new_product_oem',
                'cyclon_specifications',
                'cyclon_new_product_cat', // Subcategories as Applications
            )
        ));
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

// Disable FacetWP on cyclon_new_product_cat archives (we handle sorting ourselves)
add_filter('facetwp_is_main_query', function ($is_main_query, $query) {
    if (is_tax('cyclon_new_product_cat')) {
        return false; // Tell FacetWP to ignore this archive
    }
    return $is_main_query;
}, 10, 2);

// Helper function to sort posts by cyclon_range taxonomy
// Order: evo, pro, eco, max, then alphabetically by title
function cyclon_sort_posts_by_range($posts)
{
    if (empty($posts)) {
        return $posts;
    }

    $range_order = array('evo' => 1, 'pro' => 2, 'eco' => 3, 'max' => 4);

    usort($posts, function ($a, $b) use ($range_order) {
        $terms_a = wp_get_object_terms($a->ID, 'cyclon_range', array('fields' => 'slugs'));
        $terms_b = wp_get_object_terms($b->ID, 'cyclon_range', array('fields' => 'slugs'));

        $has_range_a = !is_wp_error($terms_a) && !empty($terms_a);
        $has_range_b = !is_wp_error($terms_b) && !empty($terms_b);

        if ($has_range_a && $has_range_b) {
            $slug_a = strtolower($terms_a[0]);
            $slug_b = strtolower($terms_b[0]);

            $pos_a = isset($range_order[$slug_a]) ? $range_order[$slug_a] : 999;
            $pos_b = isset($range_order[$slug_b]) ? $range_order[$slug_b] : 999;

            if ($pos_a !== $pos_b) {
                return $pos_a - $pos_b;
            }
        }

        if ($has_range_a && !$has_range_b) return -1;
        if (!$has_range_a && $has_range_b) return 1;

        // Same range or both without range - sort alphabetically by title
        return strcasecmp($a->post_title, $b->post_title);
    });

    return $posts;
}

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
        $term = get_term($oil_category_link, 'cyclon_new_product_cat');
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
