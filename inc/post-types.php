<?php
if (! function_exists('cyclon_product_pt')) {

    // Register Custom Post Type
    function cyclon_product_pt()
    {

        $labels = array(
            'name'                  => _x('Products', 'Post Type General Name', 'cyclon'),
            'singular_name'         => _x('Product', 'Post Type Singular Name', 'cyclon'),
            'menu_name'             => __('Products', 'cyclon'),
            'name_admin_bar'        => __('Product', 'cyclon'),
            'archives'              => __('Item Archives', 'cyclon'),
            'attributes'            => __('Item Attributes', 'cyclon'),
            'parent_item_colon'     => __('Parent Item:', 'cyclon'),
            'all_items'             => __('All Items', 'cyclon'),
            'add_new_item'          => __('Add New Item', 'cyclon'),
            'add_new'               => __('Add New', 'cyclon'),
            'new_item'              => __('New Item', 'cyclon'),
            'edit_item'             => __('Edit Item', 'cyclon'),
            'update_item'           => __('Update Item', 'cyclon'),
            'view_item'             => __('View Item', 'cyclon'),
            'view_items'            => __('View Items', 'cyclon'),
            'search_items'          => __('Search Item', 'cyclon'),
            'not_found'             => __('Not found', 'cyclon'),
            'not_found_in_trash'    => __('Not found in Trash', 'cyclon'),
            'featured_image'        => __('Featured Image', 'cyclon'),
            'set_featured_image'    => __('Set featured image', 'cyclon'),
            'remove_featured_image' => __('Remove featured image', 'cyclon'),
            'use_featured_image'    => __('Use as featured image', 'cyclon'),
            'insert_into_item'      => __('Insert into item', 'cyclon'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'cyclon'),
            'items_list'            => __('Items list', 'cyclon'),
            'items_list_navigation' => __('Items list navigation', 'cyclon'),
            'filter_items_list'     => __('Filter items list', 'cyclon'),
        );
        $args = array(
            'label'                 => __('Product', 'cyclon'),
            'description'           => __('Post Type Description', 'cyclon'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'              => 'dashicons-cart',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type('cyclon_product', $args);
    }
    add_action('init', 'cyclon_product_pt', 0);
}
if (! function_exists('cyclon_product_category')) {

    // Register Custom Taxonomy
    function cyclon_product_category()
    {

        $labels = array(
            'name'                       => _x('Product Categories', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('Product Category', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('Product Category', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_product_cat', array('cyclon_product'), $args);
    }
    add_action('init', 'cyclon_product_category', 0);
}


// New Product CPT
if (! function_exists('cyclon_new_product_pt')) {

    // Register Custom Post Type
    function cyclon_new_product_pt()
    {

        $labels = array(
            'name'                  => _x('New Products', 'Post Type General Name', 'cyclon'),
            'singular_name'         => _x('New Product', 'Post Type Singular Name', 'cyclon'),
            'menu_name'             => __('New Products', 'cyclon'),
            'name_admin_bar'        => __('New Product', 'cyclon'),
            'archives'              => __('Item Archives', 'cyclon'),
            'attributes'            => __('Item Attributes', 'cyclon'),
            'parent_item_colon'     => __('Parent Item:', 'cyclon'),
            'all_items'             => __('All Items', 'cyclon'),
            'add_new_item'          => __('Add New Item', 'cyclon'),
            'add_new'               => __('Add New', 'cyclon'),
            'new_item'              => __('New Item', 'cyclon'),
            'edit_item'             => __('Edit Item', 'cyclon'),
            'update_item'           => __('Update Item', 'cyclon'),
            'view_item'             => __('View Item', 'cyclon'),
            'view_items'            => __('View Items', 'cyclon'),
            'search_items'          => __('Search Item', 'cyclon'),
            'not_found'             => __('Not found', 'cyclon'),
            'not_found_in_trash'    => __('Not found in Trash', 'cyclon'),
            'featured_image'        => __('Featured Image', 'cyclon'),
            'set_featured_image'    => __('Set featured image', 'cyclon'),
            'remove_featured_image' => __('Remove featured image', 'cyclon'),
            'use_featured_image'    => __('Use as featured image', 'cyclon'),
            'insert_into_item'      => __('Insert into item', 'cyclon'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'cyclon'),
            'items_list'            => __('Items list', 'cyclon'),
            'items_list_navigation' => __('Items list navigation', 'cyclon'),
            'filter_items_list'     => __('Filter items list', 'cyclon'),
        );
        $args = array(
            'label'                 => __('New Product', 'cyclon'),
            'description'           => __('Post Type Description', 'cyclon'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'              => 'dashicons-cart',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type('cyclon_new_product', $args);
    }
    add_action('init', 'cyclon_new_product_pt', 0);
}
if (! function_exists('cyclon_new_product_category')) {

    // Register Custom Taxonomy
    function cyclon_new_product_category()
    {

        $labels = array(
            'name'                       => _x('New Product Categories', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('New Product Category', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('New Product Category', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_new_product_cat', array('cyclon_new_product'), $args);
    }
    add_action('init', 'cyclon_new_product_category', 0);
}

/**
 * Add taxonomy filter dropdowns to New Products admin list.
 * Filters: cyclon_new_product_cat (category), cyclon_product_grade, cyclon_range.
 */
if (! function_exists('cyclon_new_product_admin_taxonomy_filters')) {

    function cyclon_new_product_admin_taxonomy_filters()
    {
        global $typenow;
        if ('cyclon_new_product' !== $typenow) {
            return;
        }
        $tax_slugs = array('cyclon_new_product_cat', 'cyclon_product_grade', 'cyclon_range');
        foreach ($tax_slugs as $tax_slug) {
            $tax = get_taxonomy($tax_slug);
            if (! $tax) {
                continue;
            }
            $selected = isset($_GET[ $tax_slug ]) ? sanitize_text_field(wp_unslash($_GET[ $tax_slug ])) : '';
            $info = $tax->labels->name;
            wp_dropdown_categories(array(
                'show_option_all' => sprintf(/* translators: %s: taxonomy label */ __('All %s', 'cyclon'), $info),
                'taxonomy'        => $tax_slug,
                'name'            => $tax_slug,
                'orderby'         => 'name',
                'selected'        => $selected,
                'show_count'      => true,
                'hide_empty'      => false,
                'value_field'     => 'slug',
                'hierarchical'    => true,
            ));
        }
    }
    add_action('restrict_manage_posts', 'cyclon_new_product_admin_taxonomy_filters');

    function cyclon_new_product_admin_taxonomy_filters_query($query)
    {
        global $pagenow, $typenow;
        if ('edit.php' !== $pagenow || 'cyclon_new_product' !== $typenow || ! $query->is_main_query()) {
            return;
        }
        $tax_slugs = array('cyclon_new_product_cat', 'cyclon_product_grade', 'cyclon_range');
        $tax_query = array();
        foreach ($tax_slugs as $tax_slug) {
            if (empty($_GET[ $tax_slug ])) {
                continue;
            }
            $term_slug = sanitize_text_field(wp_unslash($_GET[ $tax_slug ]));
            if ('' === $term_slug) {
                continue;
            }
            $tax_query[] = array(
                'taxonomy' => $tax_slug,
                'field'    => 'slug',
                'terms'    => $term_slug,
            );
        }
        if (! empty($tax_query)) {
            $query->set('tax_query', $tax_query);
        }
    }
    add_action('pre_get_posts', 'cyclon_new_product_admin_taxonomy_filters_query');
}

/**
 * Add taxonomy filter dropdowns to Products admin list.
 * Filters: cyclon_product_cat (category).
 */
if (! function_exists('cyclon_product_admin_taxonomy_filters')) {

    function cyclon_product_admin_taxonomy_filters()
    {
        global $typenow;
        if ('cyclon_product' !== $typenow) {
            return;
        }
        $tax_slugs = array('cyclon_product_cat');
        foreach ($tax_slugs as $tax_slug) {
            $tax = get_taxonomy($tax_slug);
            if (! $tax) {
                continue;
            }
            $selected = isset($_GET[ $tax_slug ]) ? sanitize_text_field(wp_unslash($_GET[ $tax_slug ])) : '';
            $info = $tax->labels->name;
            wp_dropdown_categories(array(
                'show_option_all' => sprintf(/* translators: %s: taxonomy label */ __('All %s', 'cyclon'), $info),
                'taxonomy'        => $tax_slug,
                'name'            => $tax_slug,
                'orderby'         => 'name',
                'selected'        => $selected,
                'show_count'      => true,
                'hide_empty'      => false,
                'value_field'     => 'slug',
                'hierarchical'    => $tax->hierarchical,
            ));
        }
    }
    add_action('restrict_manage_posts', 'cyclon_product_admin_taxonomy_filters');

    function cyclon_product_admin_taxonomy_filters_query($query)
    {
        global $pagenow, $typenow;
        if ('edit.php' !== $pagenow || 'cyclon_product' !== $typenow || ! $query->is_main_query()) {
            return;
        }
        $tax_slugs = array('cyclon_product_cat');
        $tax_query = array();
        foreach ($tax_slugs as $tax_slug) {
            if (empty($_GET[ $tax_slug ])) {
                continue;
            }
            $term_slug = sanitize_text_field(wp_unslash($_GET[ $tax_slug ]));
            if ('' === $term_slug) {
                continue;
            }
            $tax_query[] = array(
                'taxonomy' => $tax_slug,
                'field'    => 'slug',
                'terms'    => $term_slug,
            );
        }
        if (! empty($tax_query)) {
            $query->set('tax_query', $tax_query);
        }
    }
    add_action('pre_get_posts', 'cyclon_product_admin_taxonomy_filters_query');
}

if (! function_exists('cyclon_specifications')) {

    // Register Custom Taxonomy
    function cyclon_specifications()
    {

        $labels = array(
            'name'                       => _x('Specifications', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('Specifications', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('Specifications', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_specifications', array('cyclon_new_product'), $args);
    }
    add_action('init', 'cyclon_specifications', 0);
}

if (! function_exists('cyclon_new_product_acea')) {

    // Register Custom Taxonomy
    function cyclon_new_product_acea()
    {

        $labels = array(
            'name'                       => _x('ACEA', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('ACEA', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('ACEA', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_new_product_acea', array('cyclon_new_product'), $args);
    }
    add_action('init', 'cyclon_new_product_acea', 0);
}
if (! function_exists('cyclon_new_product_oem')) {

    // Register Custom Taxonomy
    function cyclon_new_product_oem()
    {

        $labels = array(
            'name'                       => _x('OEM', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('OEM', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('OEM', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_new_product_oem', array('cyclon_new_product'), $args);
    }
    add_action('init', 'cyclon_new_product_oem', 0);
}

if (! function_exists('cyclon_product_grade')) {

    // Register Custom Taxonomy
    function cyclon_product_grade()
    {

        $labels = array(
            'name'                       => _x('Grades', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('Grade', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('Grade', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_product_grade', array('cyclon_product', 'cyclon_new_product'), $args);
    }
    add_action('init', 'cyclon_product_grade', 0);
}
if (! function_exists('cyclon_product_type')) {

    // Register Custom Taxonomy
    function cyclon_product_type()
    {

        $labels = array(
            'name'                       => _x('Types', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('Type', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('Type', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_product_type', array('cyclon_product', 'cyclon_new_product'), $args);
    }
    add_action('init', 'cyclon_product_type', 0);
}
if (! function_exists('cyclon_product_soap')) {

    // Register Custom Taxonomy
    function cyclon_product_soap()
    {

        $labels = array(
            'name'                       => _x('Soaps', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('Soap', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('Soap', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_product_soap', array('cyclon_product'), $args);
    }
    add_action('init', 'cyclon_product_soap', 0);
}

if (! function_exists('cyclon_product_nlgi')) {

    // Register Custom Taxonomy
    function cyclon_product_nlgi()
    {

        $labels = array(
            'name'                       => _x('NLGI', 'Taxonomy General Name', 'cyclon'),
            'singular_name'              => _x('NLGI', 'Taxonomy Singular Name', 'cyclon'),
            'menu_name'                  => __('NLGI', 'cyclon'),
            'all_items'                  => __('All Items', 'cyclon'),
            'parent_item'                => __('Parent Item', 'cyclon'),
            'parent_item_colon'          => __('Parent Item:', 'cyclon'),
            'new_item_name'              => __('New Item Name', 'cyclon'),
            'add_new_item'               => __('Add New Item', 'cyclon'),
            'edit_item'                  => __('Edit Item', 'cyclon'),
            'update_item'                => __('Update Item', 'cyclon'),
            'view_item'                  => __('View Item', 'cyclon'),
            'separate_items_with_commas' => __('Separate items with commas', 'cyclon'),
            'add_or_remove_items'        => __('Add or remove items', 'cyclon'),
            'choose_from_most_used'      => __('Choose from the most used', 'cyclon'),
            'popular_items'              => __('Popular Items', 'cyclon'),
            'search_items'               => __('Search Items', 'cyclon'),
            'not_found'                  => __('Not Found', 'cyclon'),
            'no_terms'                   => __('No items', 'cyclon'),
            'items_list'                 => __('Items list', 'cyclon'),
            'items_list_navigation'      => __('Items list navigation', 'cyclon'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('cyclon_product_nlgi', array('cyclon_product'), $args);
    }
    add_action('init', 'cyclon_product_nlgi', 0);
}

// Register Custom Taxonomy Range
function cyclon_product_range()
{
    $labels = array(
        'name' => _x('Ranges', 'Taxonomy General Name', 'cyclon'),
        'singular_name' => _x('Range', 'Taxonomy Singular Name', 'cyclon'),
        'menu_name' => __('Range', 'cyclon'),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );

    register_taxonomy('cyclon_range', array('cyclon_new_product'), $args);
}
add_action('init', 'cyclon_product_range', 0);

if (! function_exists('cyclon_sales_pt')) {

    // Register Custom Post Type
    function cyclon_sales_pt()
    {

        $labels = array(
            'name'                  => _x('Sales PT', 'Post Type General Name', 'cyclon'),
            'singular_name'         => _x('Sales PT', 'Post Type Singular Name', 'cyclon'),
            'menu_name'             => __('Sales PT', 'cyclon'),
            'name_admin_bar'        => __('Sales PT', 'cyclon'),
            'archives'              => __('Item Archives', 'cyclon'),
            'attributes'            => __('Item Attributes', 'cyclon'),
            'parent_item_colon'     => __('Parent Item:', 'cyclon'),
            'all_items'             => __('All Items', 'cyclon'),
            'add_new_item'          => __('Add New Item', 'cyclon'),
            'add_new'               => __('Add New', 'cyclon'),
            'new_item'              => __('New Item', 'cyclon'),
            'edit_item'             => __('Edit Item', 'cyclon'),
            'update_item'           => __('Update Item', 'cyclon'),
            'view_item'             => __('View Item', 'cyclon'),
            'view_items'            => __('View Items', 'cyclon'),
            'search_items'          => __('Search Item', 'cyclon'),
            'not_found'             => __('Not found', 'cyclon'),
            'not_found_in_trash'    => __('Not found in Trash', 'cyclon'),
            'featured_image'        => __('Featured Image', 'cyclon'),
            'set_featured_image'    => __('Set featured image', 'cyclon'),
            'remove_featured_image' => __('Remove featured image', 'cyclon'),
            'use_featured_image'    => __('Use as featured image', 'cyclon'),
            'insert_into_item'      => __('Insert into item', 'cyclon'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'cyclon'),
            'items_list'            => __('Items list', 'cyclon'),
            'items_list_navigation' => __('Items list navigation', 'cyclon'),
            'filter_items_list'     => __('Filter items list', 'cyclon'),
        );
        $args = array(
            'label'                 => __('Sale PT', 'cyclon'),
            'description'           => __('Post Type Description', 'cyclon'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type('cyclon_sale_pt', $args);
    }
    add_action('init', 'cyclon_sales_pt', 0);
}

if (! function_exists('cyclon_marine_sales_pt')) {

    // Register Custom Post Type
    function cyclon_marine_sales_pt()
    {

        $labels = array(
            'name'                  => _x('Marine Sales PT', 'Post Type General Name', 'cyclon'),
            'singular_name'         => _x('Marine Sales PT', 'Post Type Singular Name', 'cyclon'),
            'menu_name'             => __('Marine Sales PT', 'cyclon'),
            'name_admin_bar'        => __('Marine Sales PT', 'cyclon'),
            'archives'              => __('Item Archives', 'cyclon'),
            'attributes'            => __('Item Attributes', 'cyclon'),
            'parent_item_colon'     => __('Parent Item:', 'cyclon'),
            'all_items'             => __('All Items', 'cyclon'),
            'add_new_item'          => __('Add New Item', 'cyclon'),
            'add_new'               => __('Add New', 'cyclon'),
            'new_item'              => __('New Item', 'cyclon'),
            'edit_item'             => __('Edit Item', 'cyclon'),
            'update_item'           => __('Update Item', 'cyclon'),
            'view_item'             => __('View Item', 'cyclon'),
            'view_items'            => __('View Items', 'cyclon'),
            'search_items'          => __('Search Item', 'cyclon'),
            'not_found'             => __('Not found', 'cyclon'),
            'not_found_in_trash'    => __('Not found in Trash', 'cyclon'),
            'featured_image'        => __('Featured Image', 'cyclon'),
            'set_featured_image'    => __('Set featured image', 'cyclon'),
            'remove_featured_image' => __('Remove featured image', 'cyclon'),
            'use_featured_image'    => __('Use as featured image', 'cyclon'),
            'insert_into_item'      => __('Insert into item', 'cyclon'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'cyclon'),
            'items_list'            => __('Items list', 'cyclon'),
            'items_list_navigation' => __('Items list navigation', 'cyclon'),
            'filter_items_list'     => __('Filter items list', 'cyclon'),
        );
        $args = array(
            'label'                 => __('Sale PT', 'cyclon'),
            'description'           => __('Post Type Description', 'cyclon'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type('cyclon_marin_sale_pt', $args);
    }
    add_action('init', 'cyclon_marine_sales_pt', 0);
}
