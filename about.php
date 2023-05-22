<?php

// Template name: O nas
get_header();

?>

    <main>
        <section class="about">
            <div class="about__section3">
                <?php 
                    $args1 = array(
                        'post_type' => 'aboutus'
                    );

                    $custom_aboutus1 = new WP_Query($args1);
                                
                    if ($custom_aboutus1->have_posts()) {
                        while ($custom_aboutus1->have_posts()) {
                            $custom_aboutus1->the_post();
                ?>
                <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small-headline-aboutus1', true); ?></p>
                <h2><?php echo get_post_meta(get_the_ID(), 'headline-aboutus1', true); ?></h2>
                <p><?php echo get_post_meta(get_the_ID(), 'text-aboutus1', true); ?></p>
                <?php
                        }
                    }
                    
                    $args2 = array(
                        'post_type' => 'main_page'
                    );

                    $custom_aboutus_main1 = new WP_Query($args2);
                                
                    if ($custom_aboutus_main1->have_posts()) {
                        while ($custom_aboutus_main1->have_posts()) {
                            $custom_aboutus_main1->the_post();
                ?>
                <div class="about__section3-imgcolumns">
                    <div class="about__section3-imgcolumn">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_section2_photo_1', true),'full')[0]; ?>" />
                    </div>
                    <div class="about__section3-imgcolumn">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_section2_photo_2', true),'full')[0]; ?>" />
                    </div>
                    <div class="about__section3-imgcolumn">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_section2_photo_3', true),'full')[0]; ?>" />
                    </div>
                </div>
                <?php
                        }
                    }

                    $args3 = array(
                        'post_type' => 'aboutus'
                    );

                    $custom_aboutus2 = new WP_Query($args3);
                                
                    if ($custom_aboutus2->have_posts()) {
                        while ($custom_aboutus2->have_posts()) {
                            $custom_aboutus2->the_post();
                ?>
                <div class="about__section3-columns">
                    <div class="about__section3-column">
                        <h6><?php echo get_post_meta(get_the_ID(), 'small-headline-aboutus2', true); ?></h6>
                        <h3><?php echo get_post_meta(get_the_ID(), 'headline-aboutus2', true); ?></h3>
                        <p><?php echo get_post_meta(get_the_ID(), 'text-aboutus2', true); ?></p>
                    </div>
                    <?php
                            }
                        }
                    
                        $args4 = array(
                            'post_type' => 'main_page'
                        );

                        $custom_aboutus_main2 = new WP_Query($args4);
                                    
                        if ($custom_aboutus_main2->have_posts()) {
                            while ($custom_aboutus_main2->have_posts()) {
                                $custom_aboutus_main2->the_post();
                    ?>
                    <div class="about__section3-column">
                        <div>
                            <h3><?php echo get_post_meta(get_the_ID(), 'project2', true); ?></h3>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape.png">
                            <p><?php echo get_post_meta(get_the_ID(), 'text-project2', true); ?></p>
                        </div>
                        <div>
                            <h3><?php echo get_post_meta(get_the_ID(), 'professional2', true); ?></h3>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape.png">
                            <p><?php echo get_post_meta(get_the_ID(), 'text-professional2', true); ?></p>
                        </div>
                        <div>
                            <h3><?php echo get_post_meta(get_the_ID(), 'happy2', true); ?></h3>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape.png">
                            <p><?php echo get_post_meta(get_the_ID(), 'text-happy2', true); ?></p>
                        </div>
                        <div>
                            <h3><?php echo get_post_meta(get_the_ID(), 'experience2', true); ?></h3>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape.png">
                            <p><?php echo get_post_meta(get_the_ID(), 'text-experience2', true); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-lightblue">
                <div class="about-lightblue__section4">
                    <div class="about-lightblue__section4-columns">
                        <div class="about-lightblue__section4-column">
                            <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small_headline3', true); ?></p>
                            <h2><?php echo get_post_meta(get_the_ID(), 'headline3', true); ?></h2>
                            <p><?php echo get_post_meta(get_the_ID(), 'textarea3', true); ?></p>
                        </div>
                        <div class="about-lightblue__section4-column">
                            <div class="about-lightblue__section4-rows">
                                <div class="about-lightblue__section4-imgcolumn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/delivery.svg">
                                </div>
                                <div class="about-lightblue__section4-textcolumn">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title31', true); ?></h6>
                                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'text31', true); ?></p>
                                </div>
                            </div>
                            <div class="about-lightblue__section4-rows">
                                <div class="about-lightblue__section4-imgcolumn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/quality.svg">
                                </div>
                                <div class="about-lightblue__section4-textcolumn">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title32', true); ?></h6>
                                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'text32', true); ?></p>
                                </div>
                            </div>
                            <div class="about-lightblue__section4-rows">
                                <div class="about-lightblue__section4-imgcolumn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/assist.svg">
                                </div>
                                <div class="about-lightblue__section4-textcolumn">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title33', true); ?></h6>
                                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'text33', true); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                        }
                    }

                    $args5 = array(
                        'post_type' => 'aboutus'
                    );

                    $custom_aboutus3 = new WP_Query($args5);
                                
                    if ($custom_aboutus3->have_posts()) {
                        while ($custom_aboutus3->have_posts()) {
                            $custom_aboutus3->the_post();
            ?>
            <div class="about__section5">
                <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small-headline-aboutus3', true); ?></p>
                <h2><?php echo get_post_meta(get_the_ID(), 'headline-aboutus3', true); ?></h2>
                <p><?php echo get_post_meta(get_the_ID(), 'text-aboutus3', true); ?></p>
                <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_1', true),'full')[0]; ?>">
            </div>
            <div class="about__section6">
                <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small-headline-aboutus4', true); ?></p>
                <h2><?php echo get_post_meta(get_the_ID(), 'headline-aboutus4', true); ?></h2>
                <p><?php echo get_post_meta(get_the_ID(), 'text-aboutus4', true); ?></p>
                <div class="about__section6-team">
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_2', true),'full')[0]; ?>">
                    </div>
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_3', true),'full')[0]; ?>">
                    </div>
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_4', true),'full')[0]; ?>">
                    </div>
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_5', true),'full')[0]; ?>">
                    </div>
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_6', true),'full')[0]; ?>">
                    </div>
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_7', true),'full')[0]; ?>">
                    </div>
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_8', true),'full')[0]; ?>">
                    </div>
                    <div class="team-member">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'aboutus_photo_9', true),'full')[0]; ?>">
                    </div>
                </div>
            </div>
            <?php
                    }
                }        
            ?>
        </section>
    </main>

<?php get_footer(); ?>