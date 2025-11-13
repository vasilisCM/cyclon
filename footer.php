<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Thinktank
 */

?>
<?php if (
    !is_tax()
    && !is_singular('cyclon_product')
    && !is_page('network')
    && !is_page('customer-support')
    && !is_page('quality')
    && !is_page('contact')
): ?>




    <section class="lubeFinder" id="lubeFinder">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <img src="/wp-content/uploads/2022/04/Group-12359.png"
                        class="img-responsive lubelogo" />
                    <p>
                        <?php echo __('Find the appropriate Cyclon lubricant for your vehicle or equipment!!', 'cyclon'); ?>
                    </p>
                    <a class="mButton mButton--trans lubeFinder_popup" href="<?php echo __('https://lpc-cyclon.ewp.earlweb.net/en_GB', 'cyclon'); ?>" target="_blank"><?php echo __('DISCOVER NOW', 'cyclon'); ?></a>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                    <div class="engine">

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>

<section class="cyclonNewsletter">
    <div class="container">
        <div class="row g-0">
            <div class="newsLetterRight">
                <h3><?php echo __('Discover Cyclon<br/>on <strong>Social Media</strong>', 'cyclon'); ?></h3>
                <div class="newsLetterRight-line">
                    <hr />
                </div>
                <ul class="footerSocials">
                    <li>
                        <a href="https://www.facebook.com/CyclonLPC/" target="_blank">
                            <img src="/wp-content/uploads/2022/04/facebook.svg"
                                class="img-responsive" />
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/cyclon_lubricants/" target="_blank">
                            <img src="/wp-content/uploads/2022/04/2111491.svg"
                                class="img-responsive" />
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/channel/UCbVhNp2KVrghrcPRbvaZcfw" target="_blank">
                            <img src="/wp-content/uploads/2022/04/Subtraction-1-1.svg"
                                class="img-responsive" />
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/company/lpc-s-a/" target="_blank">
                            <img src="/wp-content/uploads/2022/04/2111532.svg"
                                class="img-responsive" />
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


</section>
<footer id="colophon" class="site-footer">

    <div class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

            <div>
                <picture>
                    <source
                        media="(max-width: 1023px)"
                        srcset="/wp-content/uploads/2025/10/intro-banner.jpg">
                    <img
                        src="/wp-content/uploads/2025/10/intro-banner.jpg"
                        alt="">
                </picture>

            </div>




        </div>



    </div>

    <!-- Footer top -->
    <?php get_template_part('template-parts/footer/footer-top', 'tpl'); ?>

    <!-- Footer Bottom -->
    <?php get_template_part('template-parts/footer/footer-bottom', 'tpl'); ?>

</footer>
<section class="belowFooter">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="belowFooter__Top">
                    <img src="/wp-content/uploads/2025/06/logo-footer.png"
                        class="img-responsive footer-logo" />
                    <hr />
                    <img src="/wp-content/uploads/2022/04/Group-16404.svg"
                        class="img-responsive member-logo" />
                </div>
                <div class="belowFooter__Bottom">
                    <p>
                        Leoforos Megaridos 124, Aspropyrgos Attikis, <br /> +30 210 809 3900
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="site-copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-12 col-md-6 mob-order-2">
                © Cyclon-LPC <?php echo date("Y"); ?>. All rights reserved. Created by Concept Maniax.
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 mob-order-1">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'copyright-nav',
                        'menu_id' => 'copyright-nav',
                        'menu_container' => false,
                        'menu_class' => 'copyright-menu'
                    )
                );
                ?>
            </div>
        </div>
    </div>
</section>
<!--	<footer id="colophon" class="site-footer">-->

<!--	</footer>< #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<div class="mobileMenuOverlay">
    <div class="mobileMenuOverlay__Inner">
        <?php wp_nav_menu(
            array(
                'theme_location' => 'mobile-nav',
                'menu_id' => 'mobile-menu',
                'menu_container' => false,
                'menu_class' => 'cyclon__mobile_menu'
            )
        ); ?>

        <div class="mobileMenu__Bottom">
            <div class="mobileLanguage">
                <span class="mobileLanguage__text"><?php echo __('Language', 'cyclon'); ?></span>
                <?php do_action('wpml_add_language_selector'); ?>
            </div>
        </div>


        <!-- Display None -->
        <section class="cyclon-categories mobileCategories">

            <div class="container">
                <div class="row g-2 g-sm-3 g-md-3 g-lg-3">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/passenger-car-lubricants/">
                                    <img src="/wp-content/uploads/2022/04/Mask-Group-157.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/passenger-car-lubricants/">
                                    <img src="/wp-content/uploads/2022/06/logo-magma.svg">
                                </a>
                            </div>
                            <h4>Passenger Car Lubricants</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/heavy-duty-lubricants/">
                                    <img src="/wp-content/uploads/2022/04/Mask-Group-158.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/heavy-duty-lubricants/">
                                    <img src="/wp-content/uploads/2022/06/logo-granit.svg">
                                </a>
                            </div>
                            <h4>Heavy Duty Lubricants</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/motorcycle-lubricants/">
                                    <img src="/wp-content/uploads/2022/04/Mask-Group-159.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/motorcycle-lubricants/">
                                    <img src="/wp-content/uploads/2022/06/logo-lava.svg">
                                </a>
                            </div>
                            <h4>Motocycle Lubricants</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/gear/">
                                    <img src="/wp-content/uploads/2022/04/Mask-Group-160.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/gear/">
                                    <img src="/wp-content/uploads/2022/06/logo-gear.svg">
                                </a>
                            </div>
                            <h4>Trasmission Lubricants</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/industrial-lubricants/">
                                    <img src="/wp-content/uploads/2022/04/Mask-Group-161.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/industrial-lubricants/">
                                    <img src="/wp-content/uploads/2022/06/logo-industrial.svg">
                                </a>
                            </div>
                            <h4>Industrial Lubricants</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/marine-lubricants/">
                                    <img src="/wp-content/uploads/2022/04/Mask-Group-249.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/marine-lubricants/">
                                    <img src="/wp-content/uploads/2022/06/logo-marine.svg">
                                </a>
                            </div>
                            <h4>Marine Lubricants</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/greases/">
                                    <img src="/wp-content/uploads/2022/06/home-greases.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/greases/">
                                    <img src="/wp-content/uploads/2022/06/logo-greases.svg">
                                </a>
                            </div>
                            <h4>Greases</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="catBox">
                            <div class="catBox__Inner">
                                <a href="/special-products/">
                                    <img src="/wp-content/uploads/2022/04/Mask-Group-164.png" class="catBoxImage">
                                </a>
                            </div>
                            <div>
                                <a href="/special-products/">
                                    <img src="/wp-content/uploads/2022/06/logo-special-fluids.svg">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<?php if (is_page('network')): ?>

    <script type="text/javascript">
        jQuery(document).ready(function($) {

            var iconBase = '/wp-content/themes/cyclon/img/';
            map = new google.maps.Map(document.getElementById("netWorkMapInner"), {
                center: {
                    lat: parseFloat(36.41859954343047),
                    lng: parseFloat(25.40758236257704)
                },
                zoom: 3,
                styles: [{
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#444444"
                        }]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [{
                            "color": "#f2f2f2"
                        }]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [{
                                "saturation": -10
                            },
                            {
                                "lightness": 10
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "simplified"
                        }]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{
                                "color": "#a3e2d5"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    }
                ]

            });
            var infoWindow = new google.maps.InfoWindow();
            var markers = [];

            $('.salePoint').each(function() {
                let lat = $(this).attr('data-lat');
                let long = $(this).attr('data-long');
                let type = $(this).attr('data-type');
                let windowID = $(this).attr('data-markerid');
                $iconName = '';
                if (type == 'cyclon_marin_sale_pt') {
                    $iconName = 'cyclon-marine-sales-pin.svg';
                } else {
                    $iconName = 'cyclon-sales-map-pin.svg';
                }

                const contentString = '<div class="infoWindowWrapper">' +
                    '<div class="infoWindow_Image">' +
                    '<div class="infoWindow__Content">' +
                    '<h4>' + $(this).attr('data-title') + '</h4>' +
                    '<h5>' + $(this).attr('data-address') + '</h5>' +
                    '</div>'
                '</div>';

                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(lat),
                        lng: parseFloat(long)
                    },
                    map: map,
                    icon: iconBase + $iconName,
                    title: 'Info Window',
                    info: contentString,
                    markerid: windowID
                });

                markers.push(marker);

                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(this.info);
                    infoWindow.open(map, this);

                });
                map.addListener('click', function() {
                    if (infoWindow) infoWindow.close();
                });


                $('.salePoint__Link').on('click', function() {

                    console.log('Going to..' + $(this).attr('data-markerid'));
                    letCounter = $(this).attr('data-counter');
                    let markerID = $(this).attr('data-markerid');
                    google.maps.event.trigger(markers[letCounter], 'click');


                    return false;
                });

            });

            var markersArray = [];


            $('.networkLink').on('click', function() {
                let markerIDS = [];
                markers.forEach(function(i, idx) {
                    markerIDS.push(i.markerid);
                });
                var cat = $(this).attr('data-category');
                console.log(cat);
                if (cat == 'all') {
                    console.log('all');
                    markerIDS.forEach(function(i, idx) {
                        $('#pointID-' + i).show();
                        showmarker(i);
                    });
                } else {

                    let points = $(this).attr('data-points');
                    let pointsarray = points.split(',');
                    var diff = $(markerIDS).not(pointsarray).get(); // these markers had to go away.

                    var commonArray = pointsarray.filter(value => markerIDS.includes(value));
                    console.log('same' + commonArray);

                    diff.forEach(function(i, idx) {
                        $('#pointID-' + i).hide();
                        hidemarker(i);
                    });
                    commonArray.forEach(function(i, idx) {
                        $('#pointID-' + i).show();
                        showmarker(i);
                    });
                }


                return false;
            });

            function removeMarker(id) {
                markers.forEach(function(i, idx) {
                    if (i.markerid == id) {
                        i.setVisible(false);
                        console.log(i.markerid);
                        i.setMap(null);
                        markers.splice(idx, 1);
                    }

                });
            }

            function hidemarker(id) {
                markers.forEach(function(i, idx) {
                    if (i.markerid == id) {
                        i.setVisible(false);
                    }

                });
            }

            function showmarker(id) {
                markers.forEach(function(i, idx) {
                    if (i.markerid == id) {
                        i.setVisible(true);
                    }

                });
            }


        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSZnCO_TqvvJWtx195dR56cSvCYSlx5SU"></script>
<?php endif; ?>
</body>

<script type="text/javascript">
    _linkedin_partner_id = "4527409";
    window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
    window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script>
<script type="text/javascript">
    (function(l) {
        if (!l) {
            window.lintrk = function(a, b) {
                window.lintrk.q.push([a, b])
            };
            window.lintrk.q = []
        }
        var s = document.getElementsByTagName("script")[0];
        var b = document.createElement("script");
        b.type = "text/javascript";
        b.async = true;
        b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
        s.parentNode.insertBefore(b, s);
    })(window.lintrk);
</script>
<noscript>
    <img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=4527409&fmt=gif" />
</noscript>

</html>