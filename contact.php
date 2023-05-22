<?php

// Template name: Kontakt
get_header();

?>

    <main>
        <?php 
            $args = array(
                'post_type' => 'contact'
            );

            $contact_query = new WP_Query($args);
                        
            if ($contact_query->have_posts()) {
                while ($contact_query->have_posts()) {
                    $contact_query->the_post();
        ?>
        <section class="contact">
            <div class="contact__columns">
                <div class="contact__columns-form">
                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small-headline-contact', true); ?></p>
                    <h2><?php echo get_post_meta(get_the_ID(), 'headline-contact', true); ?></h2>
                    <p><?php echo get_post_meta(get_the_ID(), 'text-contact', true); ?></p>
                    <form action="" method="post" class="ajax_contact" enctype="multipart/form-data">
                        <label for="name" class="paragraph-small">Name</label>
                        <input type="text" id="name" name="name" required class="name">
                        <label for="mail" class="paragraph-small">E-mail</label>
                        <input type="email" id="mail" name="mail" required class="mail">
                        <label for="message" class="paragraph-small">Message</label>
                        <textarea type="textarea" name="message" id="message" cols="30" rows="10" required class="message"></textarea>
                        <div>
                            <button type="submit" class="submitbtn">
                                <div class="button">
                                    <div class="button__shapes">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shapes.png" />
                                    </div>
                                    <div class="button__text">
                                        <p>Send Message &#10230;</p>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="success_form">Sent successfully</div>
                        <div class="error_form">Not sent, there is some error.</div>
                    </form>
                </div>
                <div class="contact__columns-info">
                    <div class="info__shapeup">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shapetop.png">
                    </div>
                    <div class="info__container">
                        <div class="info__container-content">
                            <p class="paragraph-small">
                                Location
                            </p>
                            <hr>
                            <p class="paragraph-large"><?php echo get_post_meta(get_the_ID(), 'location-contact', true); ?></p>
                        </div>
                        <div class="info__container-content">
                            <p class="paragraph-small">
                                Working Hour
                            </p>
                            <hr>
                            <p class="paragraph-large"><?php echo get_post_meta(get_the_ID(), 'working-hour-contact', true); ?></p>
                            <p class="paragraph-large">
                                9:00 AM to 8:00 PM
                            </p>
                            <p class="paragraph-smaller"><?php echo get_post_meta(get_the_ID(), 'working-hour-info-contact', true); ?></p>
                        </div>
                        <div class="info__container-content">
                            <p class="paragraph-small">
                                Contact Us
                            </p>
                            <hr>
                            <a href="tel:<?php echo get_post_meta(get_the_ID(), 'phone-contact', true); ?>" class="paragraph-large">
                                <?php echo get_post_meta(get_the_ID(), 'phone-contact', true); ?>
                            </a>
                            <br />
                            <a href="mailto:<?php echo get_post_meta(get_the_ID(), 'mail-contact', true); ?>" class="paragraph-small">
                                <?php echo get_post_meta(get_the_ID(), 'mail-contact', true); ?>
                            </a>
                        </div>
                        <div class="info__container-content">
                            <a href="<?php echo get_post_meta(get_the_ID(), 'facebook-contact', true); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/facebook-blue.svg" />
                            </a>
                            <a href="<?php echo get_post_meta(get_the_ID(), 'twitter-contact', true); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/twitter-blue.svg" />
                            </a>
                            <a href="<?php echo get_post_meta(get_the_ID(), 'instagram-contact', true); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/instagram-blue.svg" />
                            </a>
                            <a href="<?php echo get_post_meta(get_the_ID(), 'linkedin-contact', true); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/linkedin-blue.svg" />
                            </a>
                        </div>
                    </div>
                    <div class="info__shapeleft">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shapeleft.png">
                    </div>
                </div>
            </div>
        </section>
        <?php
            }
        } else {
            echo 'Nothing found.';
        }
        ?>
    </main>

<?php get_footer(); ?>