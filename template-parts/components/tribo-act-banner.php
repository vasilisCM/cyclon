<section class="tribo-act-banner">
    <?php $triboAct = get_field('tribo_act', 'option'); ?>
    <div class="container">
        <div class="tribo-act-banner__container">
            <div class="tribo-act-banner__logo-container">
                <div class="tribo-act-banner__logo">
                    <img src="<?php echo $triboAct['image']; ?>" alt="Tribo Act">
                </div>
                <div class="tribo-act-banner__logo-text primary">
                    <h2 class="tribo-act-banner__logo-title text-xl line-height-s">
                        <?php echo $triboAct['heading']; ?>
                    </h2>
                    <div class="tribo-act-banner__logo-moto text sans line-height-s">
                        <?php echo $triboAct['text']; ?>
                    </div>
                </div>
            </div>
            <div class="tribo-act-banner__features-container">

            </div>
            <div class="tribo-act-banner__button-container">

            </div>
        </div>
    </div>
</section>