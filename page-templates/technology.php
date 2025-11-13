<?php
/*
 * Template Name: Technology
 */
get_header(); ?>
<main id="primary" class="main-content cyclon_customer_support cyclon_technology biggerPadding"
    style="background: #E9E9E9;">

    <section class="technologyIntro">
        <div class="technologyIntro__container">
            <div>
                <p><?php echo get_field('technology_intro'); ?></p>
            </div>
        </div>
    </section>

    <!--Lubricants section -->
    <?php
    $lube = get_field('lube_info'); ?>
    <div class="sectionWrapper">
        <div class="sectionTop">
            <div class="technology-bg-div">
                <h3 class="white-text"><?php echo __('Lubricants', 'cyclon'); ?></h3>
                <img src="/wp-content/uploads/2025/06/tech-cat-img-001.png" class="img-fluid" />
            </div>
        </div>
        <div class="sectionBottom negativeMargin">


            <div class="container" style="max-width: 1720px !important;">
                <div class="row g-5">
                    <div class="col-12">
                        <div class="innerContainer">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-border-right">
                                    <div class="compBox compBox1">
                                        <h3 class="text-center">
                                            <?php echo __('COMPOSITION', 'cyclon'); ?>
                                        </h3>
                                        <div class="compBox__Image text-center">
                                            <img src="<?php echo $lube['composition_image']; ?>" class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-border-right">
                                    <div class="compBox compBox2">
                                        <h3>
                                            <?php echo __('FUNCTIONS', 'cyclon'); ?>
                                        </h3>
                                        <div class="compBox__Content">
                                            <?php
                                            $func = $lube['composition_functions'];
                                            if (!empty($func)):
                                                $funcArr = explode(',', $func);
                                                echo '<ul>';
                                                foreach ($funcArr as $f) {
                                                    echo '<li>' . $f . '</li>';
                                                }
                                                echo '</ul>';
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="compBox compBox3">
                                        <h3>
                                            <?php echo __('APPLICATIONS', 'cyclon'); ?>
                                        </h3>
                                        <div class="compBox__Content">
                                            <?php $app = $lube['application'];
                                            if (!empty($app)):
                                                $funcArr = explode(',', $app);
                                                echo '<ul>';
                                                foreach ($funcArr as $f) {
                                                    echo '<li>' . $f . '</li>';
                                                }
                                                echo '</ul>';
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Greases section -->
    <?php $greases = get_field('greases_info'); ?>
    <div class="sectionWrapper sectionWrapper--greases">
        <div class="sectionTop">
            <div class="technology-bg-div">
                <h3 class="white-text"><?php echo __('Greases', 'cyclon'); ?></h3>
                <img src="/wp-content/uploads/2025/06/technology-cat-img-002.png" class="img-fluid" />
            </div>
        </div>


        <div class="sectionBottom">
            <div class="container" style="max-width: 1720px !important;">
                <div class="row g-5">
                    <div class="col-12">
                        <div class="innerContainer">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-border-right">
                                    <div class="compBox compBox1">
                                        <h3 class="text-center">
                                            <?php echo __('COMPOSITION', 'cyclon'); ?>
                                        </h3>
                                        <div class="compBox__Image text-center">
                                            <img src="<?php echo $greases['composition_image']; ?>"
                                                class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-border-right">
                                    <div class="compBox compBox2">
                                        <h3>
                                            <?php echo __('FUNCTIONS', 'cyclon'); ?>
                                        </h3>
                                        <div class="compBox__Content">
                                            <?php
                                            $func = $greases['composition_functions'];
                                            if (!empty($func)):
                                                $funcArr = explode(',', $func);
                                                echo '<ul>';
                                                foreach ($funcArr as $f) {
                                                    echo '<li>' . $f . '</li>';
                                                }
                                                echo '</ul>';
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="compBox compBox3">
                                        <h3>
                                            <?php echo __('APPLICATIONS', 'cyclon'); ?>
                                        </h3>
                                        <div class="compBox__Content">
                                            <?php $app = $lube['application'];
                                            if (!empty($app)):
                                                $funcArr = explode(',', $app);
                                                echo '<ul>';
                                                foreach ($funcArr as $f) {
                                                    echo '<li>' . $f . '</li>';
                                                }
                                                echo '</ul>';
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Tabs -->
    <section class="tabs technologyTabs">
        <div class="container" style="max-width: 1720px !important;">
            <div class="row">
                <div class="col-12">
                    <?php
                    $leftTab = get_field('left_tab');
                    $rightTab = get_field('right_tab');
                    ?>
                    <div class="workshopTabsWrapper">
                        <div class="workShopTabsLinks">
                            <a href="#" data-tab="1" class="active">
                                <?php echo $leftTab['title']; ?>
                            </a>
                            <a href="#" data-tab="2">
                                <?php echo $rightTab['title']; ?>
                            </a>
                        </div>

                        <div class="workshopTabsContent">
                            <div id="tab1" class="workshop-tab activeTab">
                                <img src="<?php echo $leftTab['image']; ?>" class="img-fluid" />
                                <div class="workshop-contents">
                                    <div class="container">
                                        <div class="row">
                                            <?php $lubricantTexts = get_field('lubricant_texts'); ?>
                                            <div class="col-12 col-md-4 col-sm-4 col-lg-4 col-xl-4">
                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        1
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_1'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_1'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        2
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_2'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_2'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        3
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_3'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_3'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4 col-sm-4 col-lg-4 col-xl-4">

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        4
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_4'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_4'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        5
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_5'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_5'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        6
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_6'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_6'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-sm-4 col-lg-4 col-xl-4">


                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        7
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_7'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_7'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        8
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_8'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_8'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab2" class="workshop-tab">
                                <img src="<?php echo $rightTab['image']; ?>" class="img-fluid" />
                                <div class="workshop-contents">
                                    <div class="container">
                                        <div class="row">
                                            <?php $lubricantTexts = get_field('greases_texts'); ?>
                                            <div class="col-12 col-md-4 col-sm-4 col-lg-4 col-xl-4">
                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        1
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_1'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_1'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        2
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_2'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_2'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4 col-sm-4 col-lg-4 col-xl-4">
                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        3
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_3'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_3'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        4
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_4'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_4'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-sm-4 col-lg-4 col-xl-4">
                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        5
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_5'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_5'] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="workShopText">
                                                    <div class="workShopText__Number">
                                                        6
                                                    </div>
                                                    <div class="workShopText__Content">
                                                        <h4><?php echo $lubricantTexts['info_title_6'] ?></h4>
                                                        <p>
                                                            <?php echo $lubricantTexts['info_content_6'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


    </section>

</main>
<?php
get_footer();
