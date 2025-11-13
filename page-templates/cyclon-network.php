<?php
/*
 * Template Name: Network
 */
get_header();
$networkCat = $_GET['network'];
?>
<main id="primary" class="main-content cyclon_blog">
    <!-- test fpt  -->
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="headline"><?php echo __('CYCLON SALES NETWORK', 'cyclon'); ?></h2>
                <div class="smaller-container">
                    <?php the_content(); ?>
                </div>
            </div>


            <div class="col-12">

                <div class="network-search-form">
                    <form name="network-search">
                        <input type="text" name="network_keyword" class="search-network"
                            placeholder="<?php echo __('Country, City, P.C.', 'cyclon'); ?>"
                            value="<?php echo (!empty(sanitize_text_field($_GET['network_keyword'])) ? sanitize_text_field($_GET['network_keyword']) : ''); ?>">
                        <button type="submit" class="search-network-btn"><?php echo __('SEARCH', 'cyclon'); ?> <i
                                class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>


            <div class="col-12">
                <div class="networkCategories">

                    <div class="networkCategories__Grid">

                        <a href="?network=all" data-category="all" class="blogCategory__Link networkLink">
                            <?php echo __('GLOBAL Presence', 'cyclon'); ?>
                            <svg class="blogArrow" xmlns="http://www.w3.org/2000/svg" width="31.852"
                                height="17.121" viewBox="0 0 31.852 17.121">
                                <g id="Group_17058" data-name="Group 17058"
                                    transform="translate(-1321.05 -1554.851)" opacity="0.35">
                                    <path id="Path_23608" data-name="Path 23608" d="M-3854.35-12978.5H-3824"
                                        transform="translate(5176.15 14541.758)" fill="none" stroke="#fff"
                                        stroke-linecap="round" stroke-width="1.5"></path>
                                    <path id="Path_23609" data-name="Path 23609"
                                        d="M-3744.65-13022.2l7.5,7.5-7.5,7.5"
                                        transform="translate(5089.152 14578.112)" fill="none" stroke="#fff"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"></path>
                                </g>
                            </svg>
                        </a>

                        <?php
                        $mPoints = array();
                        $margs = array('post_type' => 'cyclon_marin_sale_pt', 'posts_per_page' => -1);
                        $sq = new WP_Query($margs);
                        if ($sq->have_posts()):
                            while ($sq->have_posts()): $sq->the_post();
                                $mPoints[] = get_the_ID();
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                        <a href="?network=marine-sales" data-category="marine-sales" data-points="<?php echo implode(',', $mPoints); ?>"
                            class="blogCategory__Link blogCategory__Link--lightBlue networkLink <?php echo ($networkCat == 'marine-sales' ? 'activeNetwork' : ''); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38.208" height="34.57"
                                viewBox="0 0 38.208 34.57">
                                <g id="Group_17022" data-name="Group 17022" transform="translate(1.059 0.75)">
                                    <path id="Path_1430" data-name="Path 1430"
                                        d="M6946.22,1104.561c.721.8,1.821,1.7,2.979,1.459,1.179-.244,1.913-1.6,3.106-1.76,1.652-.224,2.892,1.945,4.55,1.773,1.332-.138,2.18-1.742,3.518-1.8,1.5-.069,2.526,1.844,4.032,1.826,1.414-.017,2.35-1.725,3.761-1.8,1.588-.083,2.729,1.932,4.312,1.787,1.319-.12,2.153-1.7,3.474-1.8a4.158,4.158,0,0,1,2.4,1.048,2.592,2.592,0,0,0,3.4-.229l.557-.557"
                                        transform="translate(-6946.22 -1078.412)" fill="none" stroke="#042759"
                                        stroke-linecap="round" stroke-width="1.5" />
                                    <path id="Path_1431" data-name="Path 1431"
                                        d="M6946.22,1152.684c.721.8,1.821,1.7,2.979,1.459,1.179-.244,1.913-1.6,3.106-1.76,1.652-.223,2.892,1.945,4.55,1.773,1.332-.138,2.18-1.742,3.518-1.8,1.5-.069,2.526,1.844,4.032,1.826,1.414-.017,2.35-1.725,3.761-1.8,1.588-.083,2.729,1.932,4.312,1.787,1.319-.121,2.153-1.7,3.474-1.8a4.158,4.158,0,0,1,2.4,1.048,2.592,2.592,0,0,0,3.4-.23l.557-.557"
                                        transform="translate(-6946.22 -1121.108)" fill="none" stroke="#042759"
                                        stroke-linecap="round" stroke-width="1.5" />
                                    <path id="Path_1432" data-name="Path 1432"
                                        d="M7005.158,999.26l11.855-12.239-12.991-2.447-12.99,2.447,11.855,12.239A1.581,1.581,0,0,0,7005.158,999.26Z"
                                        transform="translate(-6985.98 -972.253)" fill="none" stroke="#042759"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                    <line id="Line_51" data-name="Line 51" y2="15.322"
                                        transform="translate(18.043 12.321)" fill="none" stroke="#042759"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                    <path id="Path_1433" data-name="Path 1433"
                                        d="M7025.545,965.649V961.3h18.2v4.348"
                                        transform="translate(-7016.599 -952.604)" fill="none" stroke="#042759"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                    <path id="Path_1434" data-name="Path 1434"
                                        d="M7055.8,927.091v-4.348h11.371v4.348"
                                        transform="translate(-7043.447 -918.395)" fill="none" stroke="#042759"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                    <path id="Path_1435" data-name="Path 1435"
                                        d="M7086.062,888.534v-4.348h4.547v4.348"
                                        transform="translate(-7070.291 -884.186)" fill="none" stroke="#042759"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                </g>
                            </svg>

                            <?php echo __('CYCLON <br/>Marine hubs', 'cyclon'); ?>
                            <svg class="blogArrow" xmlns="http://www.w3.org/2000/svg" width="31.852"
                                height="17.121" viewBox="0 0 31.852 17.121">
                                <g id="Group_17058" data-name="Group 17058"
                                    transform="translate(-1321.05 -1554.851)" opacity="0.35">
                                    <path id="Path_23608" data-name="Path 23608" d="M-3854.35-12978.5H-3824"
                                        transform="translate(5176.15 14541.758)" fill="none" stroke="#fff"
                                        stroke-linecap="round" stroke-width="1.5"></path>
                                    <path id="Path_23609" data-name="Path 23609"
                                        d="M-3744.65-13022.2l7.5,7.5-7.5,7.5"
                                        transform="translate(5089.152 14578.112)" fill="none" stroke="#fff"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"></path>
                                </g>
                            </svg>
                        </a>

                        <?php
                        $sPoints = array();
                        $margs = array('post_type' => 'cyclon_sale_pt', 'posts_per_page' => -1);
                        $sq = new WP_Query($margs);
                        if ($sq->have_posts()):
                            while ($sq->have_posts()): $sq->the_post();
                                $sPoints[] = get_the_ID();
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>

                        <a href="?network=cyclon-sales" data-category="cyclon-sales" data-points="<?php echo implode(',', $sPoints); ?>"
                            class="blogCategory__Link blogCategory__Link--lightBlue networkLink <?php echo ($networkCat == 'cyclon-sales' ? 'activeNetwork' : ''); ?>">
                            <svg id="Group_17152" data-name="Group 17152" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40"
                                viewBox="0 0 40 40">
                                <defs>
                                    <clipPath id="clip-path">
                                        <rect id="Rectangle_1796" data-name="Rectangle 1796" width="40"
                                            height="40" fill="none" stroke="#042759" stroke-width="1.5" />
                                    </clipPath>
                                </defs>
                                <line id="Line_175" data-name="Line 175" y2="7" transform="translate(15 24)"
                                    fill="none" stroke="#042759" stroke-linejoin="round" stroke-width="1.5" />
                                <g id="Group_17151" data-name="Group 17151">
                                    <g id="Group_17150" data-name="Group 17150" clip-path="url(#clip-path)">
                                        <path id="Path_26759" data-name="Path 26759"
                                            d="M12.313,30,9.958,32.356a.869.869,0,0,0-.255.615V35.5a.869.869,0,0,1-.547.808L2.641,38.917A2.61,2.61,0,0,0,1,41.34v2.584"
                                            transform="translate(-0.13 -3.924)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26760" data-name="Path 26760"
                                            d="M32,30l2.356,2.356a.869.869,0,0,1,.255.615V35.5a.869.869,0,0,0,.547.808l6.514,2.606a2.61,2.61,0,0,1,1.641,2.424v2.584"
                                            transform="translate(-4.152 -3.924)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26761" data-name="Path 26761"
                                            d="M14,34l5.564,2.385a.87.87,0,0,1,.527.8v4.648"
                                            transform="translate(-1.816 -4.443)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26762" data-name="Path 26762"
                                            d="M21.832,28.054h-.707a5.146,5.146,0,0,1-3.536-1.389,29.991,29.991,0,0,1-2.828-2.78A9.523,9.523,0,0,1,14,20.145V15"
                                            transform="translate(-1.816 -1.978)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <line id="Line_176" data-name="Line 176" y2="7"
                                            transform="translate(26 24)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26763" data-name="Path 26763"
                                            d="M31.092,34l-5.564,2.385a.87.87,0,0,0-.527.8v4.648"
                                            transform="translate(-3.243 -4.443)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26764" data-name="Path 26764"
                                            d="M23,28.054h.707a5.144,5.144,0,0,0,3.536-1.389,29.991,29.991,0,0,0,2.828-2.78,9.523,9.523,0,0,0,.761-3.74V15"
                                            transform="translate(-2.984 -1.978)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26765" data-name="Path 26765" d="M21,7.092V1h3.481V7.092"
                                            transform="translate(-2.724 -0.162)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <line id="Line_177" data-name="Line 177" x1="22"
                                            transform="translate(9 13)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26766" data-name="Path 26766"
                                            d="M17.092,5.481V2A7.493,7.493,0,0,0,11.87,8.962v.87L11,10.7v.87"
                                            transform="translate(-1.427 -0.292)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                        <path id="Path_26767" data-name="Path 26767"
                                            d="M28,5.481V2a7.493,7.493,0,0,1,5.222,6.962v.87l.87.87v.87"
                                            transform="translate(-3.633 -0.292)" fill="none" stroke="#042759"
                                            stroke-linejoin="round" stroke-width="1.5" />
                                    </g>
                                </g>
                            </svg>


                            <?php echo __('CYCLON Distributors', 'cyclon'); ?>
                            <svg class="blogArrow" xmlns="http://www.w3.org/2000/svg" width="31.852"
                                height="17.121" viewBox="0 0 31.852 17.121">
                                <g id="Group_17058" data-name="Group 17058"
                                    transform="translate(-1321.05 -1554.851)" opacity="0.35">
                                    <path id="Path_23608" data-name="Path 23608" d="M-3854.35-12978.5H-3824"
                                        transform="translate(5176.15 14541.758)" fill="none" stroke="#fff"
                                        stroke-linecap="round" stroke-width="1.5"></path>
                                    <path id="Path_23609" data-name="Path 23609"
                                        d="M-3744.65-13022.2l7.5,7.5-7.5,7.5"
                                        transform="translate(5089.152 14578.112)" fill="none" stroke="#fff"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"></path>
                                </g>
                            </svg>
                        </a>

                    </div>
                </div>
                <div class="networkMapWrapper">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-7 col-lg-7 col-xl-7">
                            <div id="networkMap">
                                <div id="netWorkMapInner">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-5 col-lg-5 col-xl-5">
                            <div class="networkPoints" style="height: 576px; ">
                                <div ss-container class="networkPoints__Inner" style="height: 100%;">
                                    <?php
                                    $selectedArgs = esc_html($_GET['network_keyword']);


                                    if ($networkCat == 'marine-sales') {
                                        $salesArgs = array(
                                            'post_type' => array('cyclon_marin_sale_pt'),
                                            'posts_per_page' => -1
                                        );
                                    } else if ($networkCat == 'cyclon-sales') {
                                        $salesArgs = array(
                                            'post_type' => array('cyclon_sale_pt'),
                                            'posts_per_page' => -1
                                        );
                                    } else {

                                        $salesArgs = array(
                                            'post_type' => array('cyclon_sale_pt', 'cyclon_marin_sale_pt'),
                                            'posts_per_page' => -1,

                                        );
                                    }
                                    if ($selectedArgs != ''):
                                        global $wpdb;
                                        $myposts = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title LIKE '%s'", '%' . $wpdb->esc_like($selectedArgs) . '%'));
                                        $posts = array();
                                        foreach ($myposts as $mypost) {
                                            $post = get_post($mypost);

                                            $myposts[] = $post->ID;
                                        }

                                        if (!empty($myposts)) {
                                            $salesArgs['post__in'] = $myposts;
                                            $salesArgs['posts_per_page'] = -1;
                                        }
                                    endif;
                                    //
                                    //print_r($myposts);

                                    if (!empty($selectedArgs) && empty($myposts)) {

                                        $salesArgs['meta_query'][] = array(
                                            'relation' => 'OR',
                                            array(
                                                'key' => 'city',
                                                'value' => $selectedArgs,
                                            ),
                                            array(
                                                'key' => 'text_address',
                                                'value' => $selectedArgs,
                                                'compare' => 'LIKE'
                                            ),
                                            array(
                                                'key' => 'zip_code',
                                                'value' => $selectedArgs,
                                            ),
                                            array(
                                                'key' => 'country',
                                                'value' => $selectedArgs,
                                            )

                                        );
                                        $salesArgs['posts_per_page'] = -1;
                                    }
                                    //                                        echo '<pre>';
                                    //                                        print_r($salesArgs);
                                    //                                        echo '</pre>';
                                    //$salesArgs[] = 'orderby'=>'menu_order';
                                    $sales = new WP_Query($salesArgs);
                                    if ($sales->have_posts()):
                                        $cou = 0;
                                        while ($sales->have_posts()): $sales->the_post(); ?>
                                            <div class="salePoint" id="pointID-<?php echo get_the_ID(); ?>"
                                                data-title="<?php echo get_the_title(); ?>"
                                                data-address="<?php the_field('text_address'); ?>"
                                                data-type="<?php echo get_post_type(); ?>"
                                                data-lat="<?php the_field('latitude'); ?>"
                                                data-long="<?php the_field('longitude'); ?>"
                                                data-markerid="<?php echo get_the_id(); ?>"
                                                data-counter="<?php echo $cou; ?>">
                                                <?php
                                                $saleType = get_post_type(get_the_ID());
                                                if ($saleType == 'cyclon_sale_pt') { ?>
                                                    <img src="/wp-content/uploads/2022/06/cyclon-sales.svg"
                                                        class="fluid-image" />
                                                <?php } else if ($saleType == 'cyclon_marin_sale_pt') { ?>
                                                    <img src=/wp-content/uploads/2022/06/cyclon-marine-sales.svg"
                                                        class="fluid-image" />
                                                <?php } ?>
                                                <div class="salePoint__Address">
                                                    <h4><?php the_title(); ?></h4>
                                                    <?php the_field('text_address'); ?>
                                                    <?php if (get_field('tel')) { ?>
                                                        <?php echo __('Tel: ', 'cyclon'); ?><?php the_field('tel'); ?>
                                                    <?php } ?>
                                                    <?php if (get_field('email')) { ?>
                                                        <?php echo __('Email: ', 'cyclon'); ?><?php the_field('email'); ?>
                                                    <?php } ?>
                                                </div>
                                                <a href="#" class="salePoint__Link"
                                                    data-markerid="<?php echo get_the_id(); ?>"
                                                    data-lat="<?php the_field('latitude'); ?>"
                                                    data-counter="<?php echo $cou; ?>"
                                                    data-long="<?php the_field('longitude'); ?>"></a>
                                            </div>
                                    <?php $cou++;
                                        endwhile;
                                    endif;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
<?php
get_footer();
