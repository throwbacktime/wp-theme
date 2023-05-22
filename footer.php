    <footer>
        <div class="footer">
            <div class="footer__subscribe">
                <div class="left-shape">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left-shape.png">
                </div>
                <div class="footer__subscribe-column">
                    <p class="paragraph-small">NEWSLETTER</p>
                    <h3>Subscribe our Newsletter to get Latest Updates.</h3>
                </div>
                <div class="footer__subscribe-column">
                    <form action="" method="post" class="ajax" enctype="multipart/form-data">
                        <input type="email" name="email" placeholder="Your Email" class="email" required>
                        <button type="submit" class="submitbtn">Send &#10230;</button>
                        <div class="success_msg">Sent successfully</div>
                        <div class="error_msg">Not sent, there is some error.</div>
                    </form>
                    <div class="right-shape">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right-shape.png">
                    </div>
                </div>
            </div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shapes-larger.png" class="footer-shape">
            <?php 
                $args = array(
                    'post_type' => 'footer'
                );

                $custom_footer = new WP_Query($args);
                            
                if ($custom_footer->have_posts()) {
                    while ($custom_footer->have_posts()) {
                        $custom_footer->the_post();
            ?>
            <div class="footer__menus">
                <div class="footer__menus-column">
                    <h2><?php echo get_post_meta(get_the_ID(), 'headline-footer', true); ?></h2>
                    <h4><?php echo get_post_meta(get_the_ID(), 'title-footer', true); ?></h4>
                    <a href="tel:<?php echo get_post_meta(get_the_ID(), 'phone-footer', true); ?>" class="paragraph-large">
                        <?php echo get_post_meta(get_the_ID(), 'phone-footer', true); ?>
                    </a><br>
                    <a href="mailto:<?php echo get_post_meta(get_the_ID(), 'mail-footer', true); ?>" class="paragraph-large">
                        <?php echo get_post_meta(get_the_ID(), 'mail-footer', true); ?>
                    </a>
                </div>
                <div class="footer__menus-column">
                    <?php
                        wp_nav_menu( array( 
                            'theme_location' => 'footer-menu-1', 
                            'container_class' => 'footer__menu-column1',
                            'menu_class' => 'footer-menu-first'
                            )
                        ); 
                    ?>
                    <div class="footer__menu-column2">
                        <h6>Service</h6>
                        <?php
                        wp_nav_menu( array( 
                            'theme_location' => 'footer-menu-2', 
                            'menu_class' => 'footer-menu-second'
                            )
                        ); 
                        ?>
                    </div>
                    <div class="footer__menu-column3">
                        <h6>Resourses</h6>
                        <?php
                        wp_nav_menu( array( 
                            'theme_location' => 'footer-menu-3', 
                            'menu_class' => 'footer-menu-third'
                            )
                        ); 
                        ?>
                    </div>
                </div>
            </div>
            <div class="footer__menus-under">
                <div>
                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'address-footer', true); ?></p>
                </div>
                <div>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'contact-us-footer', true); ?>">Contact Us &#10230;</a>
                </div>
            </div>
        </div>
        <div class="social">
            <div class="social-icons">
                <div>
                    <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'footer_photo_1', true),'full')[0]; ?>">
                    <p>©<?php echo get_post_meta(get_the_ID(), 'copyrights-footer', true); ?></p>
                </div>
                <div>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'facebook-footer', true); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/facebook.svg">
                    </a>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'twitter-footer', true); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/twitter.svg">
                    </a>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'instagram-footer', true); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/instagram.svg">
                    </a>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'linkedin-footer', true); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/linkedin.svg">
                    </a>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo 'Nothing found.';
        }
        ?>
    </footer>

<?php wp_footer(); ?>

</body>
</html>