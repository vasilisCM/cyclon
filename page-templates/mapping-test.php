<?php
/*
 * Template Name: Test Mapping
 */
get_header(); ?>
    <main id="primary" class="main-content mappingPage">

    <section class="lubeFinder" id="lubeFinder">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <img src="/wp-content/uploads/2022/04/Group-12359.png"
                         class="img-responsive lubelogo"/>
                    <p>
                    <?php echo __('Find the appropriate Cyclon lubricant for your vehicle or equipment!', 'cyclon'); ?>
                    </p>
                    <a class="mButton mButton--trans lubeFinder_popup" href="#lube_popup"><?php echo __('DISCOVER NOW', 'cyclon'); ?></a>
                </div>
                <!-- Popup -->
                
                <div id="lube_popup" class="overlay">
                    <div class="popup">
                        <a class="close" href="#">&times;</a>
                        <p class="popup-text"><?php echo __('ID Lube is undergoing a major update. The service will be available again in a few days.', 'cyclon'); ?></p>
                    </div>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                    <div class="engine">

                    </div>
                </div>
            </div>
        </div>
    </section>


    <style>
        .overlay {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            transition: opacity 500ms;
            visibility: hidden;
            opacity: 0;
        }
        .overlay:target {
            visibility: visible;
            opacity: 1;
        }

        .popup {
            background-color: #fff;
            box-shadow: 10px 10px 60px #555;
            height: auto;
            max-width: 551px;
            min-height: 100px;
            vertical-align: middle;
            width: 90%;
            position: relative;
            border-radius: 8px;
            padding: 30px;
            margin: 50vh auto 0;
            transition: all 5s ease-in-out;
        }

        .popup .close {
            position: absolute;
            top: 20px;
            right: 30px;
            transition: all 200ms;
            font-size: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }
        .popup .close:hover {
            color: #FFDB44;
        }
    </style>

        <!-- <div class="mappingMain" style="background: url('/wp-content/uploads/2022/06/background-blue-gradiend.svg') center no-repeat; background-size:cover;">
            <div class="mappingChild baseChild" style="background:url('/wp-content/uploads/2022/06/20220509-Application-Mapping-CAR.png') center no-repeat;">
                <div class="row">
                    <div class="col-4">

                    </div>
                    <div class="col-8">
                        <div class="mappingDots">
                            <a href="#" data-map="windshield" class="car-windshield-dot map-dot"></a>
                            <a href="#" data-map="engine" class="car-engine-dot map-dot"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mappingChild otherChild" data-mapid="windshield" style="background:url('/wp-content/uploads/2022/06/20220509-Application-Mapping-CAR-–-windshield.png') center no-repeat;">
                <div class="row">
                    <div class="col-4">

                    </div>
                    <div class="col-8">
                        <div class="mappingDots">
                            <a href="#" data-map="windshield" class="car-windshield-dot map-dot"></a>
                            <a href="#" data-map="engine" class="car-engine-dot map-dot"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mappingChild otherChild" data-mapid="engine" style="background:url('/wp-content/uploads/2022/06/20220509-Application-Mapping-CAR-–-engine.png') center no-repeat;">
                <div class="row">
                    <div class="col-4">

                    </div>
                    <div class="col-8">
                        <div class="mappingDots">
                            <a href="#" data-map="windshield" class="car-windshield-dot map-dot"></a>
                            <a href="#" data-map="engine" class="car-engine-dot map-dot"></a>
                        </div>
                    </div>
                </div>
            </div>


        </div> -->


<!--        <div class="mappingSuper">-->
<!--            <div class="row">-->
<!--                <div class="col-12">-->
<!--                    <div class="mappingWrapper">-->
<!--                        <div class="row">-->
<!--                            <div class="col-4">-->
<!--                                <p>test</p>-->
<!--                            </div>-->
<!--                            <div class="col-8">-->
<!--                                <div class="mappingSrcImage">-->
<!--                                    <div class="mappingDots">-->
<!--                                        <a href="#" data-map="windshield" class="car-windshield-dot map-dot"-->
<!--                                        data-image="/wp-content/uploads/2022/06/Component-2-–-1.png">-->
<!--                                        </a>-->
<!---->
<!--                                        <a href="#" data-map="engine" class="car-engine-dot map-dot"-->
<!--                                        data-image="/wp-content/uploads/2022/06/Component-5-–-1.png">-->
<!--                                        </a>-->
<!--                                    </div>-->
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </main>
<?php //get_footer();