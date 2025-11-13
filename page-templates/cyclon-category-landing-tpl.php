<?php
/*
 * Template Name: Category Landing
 */
$term = get_queried_object();
get_header(); ?>
    <main id="primary" class="main-content cyclon_product_category_content">
        <section class="saloon">
            <div class="saloon__Image">
                <img src="<?php echo get_field('saloon_image'); ?>" class="img-responsive"/>
            </div>
            <h3 class="text-center"><?php echo get_field('saloon_title'); ?></h3>
            <p class="text-center"><?php echo get_field('saloon_text'); ?></p>
            <div class="text-center">
                <!-- <a class="mButton mButton--blueButton"-->
                <!-- href="--><?php //echo get_field('saloon_btn_url'); ?><!--">--><?php //echo get_field('saloon_btn_text'); ?><!--</a> -->
                <a class="mButton" href="<?php echo get_field('saloon_btn_url'); ?>"><?php echo get_field('saloon_btn_text'); ?></a>
            </div>
        </section>

        <?php if(get_field('mapping_information')):?>
            <section class="appMapping default" id="mappingSection">
                <div class="container d-none d-md-block">
                    <div class="row">
                        <?php 
                            if(have_rows('mapping_information') && count( get_field( 'mapping_information' ) ) > 1) :
                        ?>
                            <div class="mapping-tabs-wrapper">
                            <?php
                                $countTab = 1;
                                $countSingleTab = 1;
                                $countMainTab = 0;
                                $rowNumber = -1;
                                $countAll = 1;
                                while( have_rows('mapping_information') ) : the_row();
                                    if(get_sub_field( 'general_category' )) :
                                        $previousRow = get_field('mapping_information' )[$rowNumber];
                                        $currRow = get_field('mapping_information' )[$rowNumber + 1];
                                        $previousCat = $previousRow['general_category'];
                                        $currCat = $currRow['general_category'];
                                        if(strcmp($previousCat, $currCat) != 0) :
                                            $countSingleTab = 1;
                                            $countMainTab++;
                                            ?>
                                            <div class="main-tab single-tab<?php if ($countTab == 1) { echo " active";}?>" id="single-mapping-<?php echo $countTab++; ?>"><?php echo get_sub_field( 'general_category_front' ); ?></div>
                                            <?php
                                        endif;
                                        ?>                                            
                                            <div class="single-tab single-mapping-<?php echo $countMainTab; ?><?php if ($countMainTab == 1) { echo " active";}?>" id="single-mapping-<?php echo $countAll++;?>-<?php echo $countMainTab; ?>-<?php echo $countSingleTab; ?>"><span><?php echo get_sub_field( 'general_title_front' ); ?></span></div>
                                        <?php
                                            $countSingleTab++;
                                            $rowNumber++;
                                        else :
                                    ?>
                                        <div class="single-tab gen<?php if ($countTab == 1) { echo " active";}?>" id="single-mapping-<?php echo $countTab++; ?>"><?php echo get_sub_field( 'general_title_front' ); ?></div>
                                    <?php
                                        endif;
                                    ?>
                                
                                    <?php
                                    endwhile;
                                ?>
                            </div>
                        <?php
                            endif;
                        ?>
                        <div class="col-4">
                            <div class="content-wrapper">
                                <h2><?php echo __('Cyclon products per application', 'cyclon')?></h2>
                                <div class="oil-wrapper-outer">
                                    <h3></h3>
                                    <div class="oil-wrapper">
                                        <div class="oil-content">
                                        </div>
                                        <div class="oil-image">
                                            <?php ?>
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <a class="mButton mButton--trans" href="<?php echo get_field('saloon_btn_url'); ?>"><?php echo __('VIEW ALL PRODUCTS', 'cyclon')?> </a>


                            </div>
                        </div>
                        <div class="col-8">
                            <?php
                            if( have_rows('mapping_information') ):
                                $count = 1;

                                $countTab = 1;
                                $countSingleTab = 1;
                                $countMainTab = 0;
                                $rowNumber = -1;
                                $countAll = 1;
                                while( have_rows('mapping_information') ) : the_row();
                                if(get_sub_field( 'general_category' )) :
                                    $previousRow = get_field('mapping_information' )[$rowNumber];
                                    $currRow = get_field('mapping_information' )[$rowNumber + 1];
                                    $previousCat = $previousRow['general_category'];
                                    $currCat = $currRow['general_category'];
                                    if(strcmp($previousCat, $currCat) != 0) :
                                        $countSingleTab = 1;
                                        $countMainTab++;
                                        ?>
                                        <div class="single-mapping-wrapper<?php if ($countMainTab == 1) { echo " active";}?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field( 'general_title' ))); ?>" id="content-single-mapping-<?php echo $countAll++; ?>-<?php echo $countMainTab; ?>-<?php echo $countSingleTab; ?>">
                                        <?php
                                        else:
                                        ?>
                                        <div class="single-mapping-wrapper<?php if ($countMainTab == 1) { echo " active";}?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field( 'general_title' ))); ?>" id="content-single-mapping-<?php echo $countAll++; ?>-<?php echo $countMainTab; ?>-<?php echo $countSingleTab; ?>">
                                        <?php
                                    endif;    
                                $countSingleTab++;
                                $rowNumber++;
                                else:
                            ?>
                                <div class="single-mapping-wrapper <?php if ($count == 1) { echo "active";}?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field( 'general_title' ))); ?>" id="content-single-mapping-<?php echo $count++; ?>">
                                <?php
                                endif; ?>

                                    <div class="image-wrapper" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');">
                                        <div class="default-image" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                        <div class="hidden-field" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                        <span class="line-x"></span>
                                        <span class="line-y"></span>
                                        <?php
                                        if( have_rows('part_details') ):
                                            while( have_rows('part_details') ) : the_row();
                                                $idname = strtolower(get_sub_field('part_title'));
                                                $idname = preg_replace('/\s+/', '-', $idname);  
                                        ?>
                                            <span class="dots" id="<?php echo $idname; ?>"></span>
                                        <?php
                                            endwhile;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            <?php
                                endwhile;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="container d-block d-md-none">
                    <?php
                    if( have_rows('mapping_information') ):
                        $repeater = get_field('mapping_information');
                    ?>
                    <div class="row">
                        <div class="col-12 <?php echo preg_replace('/\s+/', '-', strtolower($repeater[0]['general_title'])); ?>">
                            <h2><?php echo __('Cyclon products per application', 'cyclon')?></h2>

                            <?php $c = 1; while( have_rows('mapping_information') ) : the_row();?>
                                <div class="image-main-wrap<?php if($c == 1){echo ' active';}?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field('general_title'))); ?>" >
                                    <div class="image-wrapper<?php if($c == 1){echo ' active';}$c++;?>" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');">
                                        <div class="default-image" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                        <div class="hidden-field" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                        <?php
                                            while( have_rows('part_details') ) : the_row();
                                                $idname = strtolower(get_sub_field('part_title'));
                                                $idname = preg_replace('/\s+/', '-', $idname);  
                                            ?>
                                                <span class="dots" id="<?php echo $idname; ?>"></span>
                                            <?php
                                            endwhile;
                                        ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <?php 
                                if(have_rows('mapping_information') && count( get_field( 'mapping_information' ) ) > 1) :
                                ?>
                                <div class="custom-select main-select">
                                    <select>
                                        <?php
                                            $countTab = 0;
                                            $countSingleTab = 1;
                                            $countMainTab = 0;
                                            $rowNumber = -1;
                                            $countAll = 1;
                                            while( have_rows('mapping_information') ) : the_row();
                                                $idname = strtolower(get_sub_field('general_title'));                                 
                                                if(get_sub_field( 'general_category' )) :
                                                    $previousRow = get_field('mapping_information' )[$rowNumber];
                                                    $currRow = get_field('mapping_information' )[$rowNumber + 1];
                                                    $previousCat = $previousRow['general_category'];
                                                    $currCat = $currRow['general_category'];
                                                    
                                                    if(strcmp($previousCat, $currCat) != 0) :
                                                        $countSingleTab = 1;
                                                        $countMainTab++;
                                                        
                                                        ?>
                                                        <option value="<?php echo $countTab++; ?>" id="option-<?php echo get_sub_field( 'general_category' ); ?>" class="main-tab"><?php echo get_sub_field( 'general_category_front' ); ?></option>
                                                        <?php
                                                    endif;
                                                    
                                                        ?>
                                                        <option value="<?php echo $countTab++; ?>" id="option-<?php echo $idname; ?>"><?php echo get_sub_field( 'general_title_front' ); ?></option>
                                                        <?php
                                                    $countSingleTab++;
                                                    $rowNumber++;
                                                else :
                                                    ?> 
                                                    <option value="<?php echo $countTab++; ?>" id="option-<?php echo $idname; ?>"><?php echo get_sub_field( 'general_title_front' ); ?></option>
                                                    <?php 
                                                endif;
                                            endwhile;
                                        ?>
                                    </select>
                                </div>
                                <?php
                                endif;
                            ?>
                            <?php $c = 1; while( have_rows('mapping_information') ) : the_row();?>
                                <div class="custom-select gen-select<?php if($c == 1){echo ' active';}$c++;?>">
                                    <select>
                                        <option value="0"><?php echo __('Please select', 'cyclon'); ?></option>
                                        <?php
                                            while( have_rows('part_details') ) : the_row();
                                                $idname = strtolower(get_sub_field('part_title'));
                                                $idname = preg_replace('/\s+/', '-', $idname);  
                                                ?>
                                                    <option value="<?php echo $count++; ?>" id="option-<?php echo $idname; ?>"><?php echo get_sub_field('part_title_front'); ?></option>
                                                <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            <?php endwhile; ?>

                            <div class="oil-details">
                                <div class="oil-content"></div>
                                <div class="oil-image"><img src="" alt=""></div>
                            </div>
                            <a class="mButton mButton--trans" href="<?php echo get_field('saloon_btn_url'); ?>"><?php echo __('VIEW ALL PRODUCTS', 'cyclon')?> </a>

                            
                        </div>

                    </div>
                    <?php 
                        //endwhile;
                    endif;
                    ?>
                </div>
            </section>
        <?php endif;?>
        
        <section class="features">

 
            <!-- This is going to override the below features -->

            <?php if (have_rows('new_features')):
                while (have_rows('new_features')):the_row('new_features');

                    if (get_row_layout() == 'left_image_feature'):
                        get_template_part('template-parts/layouts/acf-left-image', 'tpl');
                    elseif (get_row_layout() == 'right_image_feature'):
                        get_template_part('template-parts/layouts/acf-right-image', 'tpl');
                    elseif (get_row_layout() == 'tribo_act_feature'):
                        get_template_part('template-parts/layouts/acf-tribo', 'tpl');
                    elseif (get_row_layout() == 'video_section_feature'):
                        get_template_part('template-parts/layouts/acf-video-section', 'tpl');
                    endif;
                endwhile;
            endif;
            ?>


            <?php
            $feature1 = get_field('feature_1');
            $feature2 = get_field('feature_2');
            ?>
            <?php if (array_filter($feature1)): ?>
                <div class="feature feature--leftImage">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Content">
                                    <h3><?php echo $feature1['feature_title']; ?></h3>
                                    <p>
                                        <?php echo $feature1['feature_content']; ?>
                                    </p>

                                    <a class="mButton mButton--blueButton"
                                       href="<?php echo $feature1['feature_button_url']; ?>">
                                        <?php echo $feature1['feature_button_text']; ?>
                                    </a>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Image">
                                    <img src="<?php echo $feature1['feature_image']; ?>" class="img-fluid"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (array_filter($feature2)): ?>
                <div class="feature feature--rightImage">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Image">
                                    <img src="<?php echo $feature2['feature_image']; ?>" class="img-fluid"/>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Content">
                                    <h3><?php echo $feature2['feature_title']; ?></h3>
                                    <p>
                                        <?php echo $feature2['feature_content']; ?>
                                    </p>

                                    <a class="mButton mButton--blueButton"
                                       href="<?php echo $feature2['feature_button_url']; ?>">
                                        <?php echo $feature2['feature_button_text']; ?>
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </section>
    </main>
<?php
get_footer();