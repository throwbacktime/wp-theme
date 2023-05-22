<?php
    get_header();
?>

    <main>
        <?php 
            $args = array(
                'post_type' => 'main_page'
            );

            $custom_query = new WP_Query($args);
                        
            if ($custom_query->have_posts()) {
                while ($custom_query->have_posts()) {
                    $custom_query->the_post();
        ?>
        <section class="home">
            <div class="home-blue">
                <div class="home-blue__section1">
                    <div class="home-blue__section1-column">
                        <h1><?php echo get_post_meta(get_the_ID(), 'headline1', true); ?></h1>
                        <p><?php echo get_post_meta(get_the_ID(), 'textarea1', true); ?></p>
                        <a href="<?php echo get_post_meta(get_the_ID(), 'url1', true); ?>" target="_blank">
                            <button>
                                <div class="button">
                                    <div class="button__shapes">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shapes.png" />
                                    </div>
                                    <div class="button__text">
                                        <p><?php echo get_post_meta(get_the_ID(), 'text1', true); ?></p>
                                    </div>
                                </div>
                            </button>
                        </a>
                    </div>
                    <div class="home-blue__section1-column right">
                        <div class="imageblocks">
                            <div class="colorblocks1">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/colorblocks1.png" />
                            </div>
                            <div class="imageblock">
                                <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_section1_photo', true),'full')[0]; ?>" />
                            </div>
                            <div class="colorblocks2">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/colorblocks2.png" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="home-blue__section2">
                    <div class="home-blue__section2-clients">
                        <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'client', true); ?></p>
                        <p class="paragraph-large"><?php echo get_post_meta(get_the_ID(), 'work', true); ?></p>
                    </div>
                    <div class="home-blue__section2-clients">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_clients_1', true),'full')[0]; ?>" />
                    </div>
                    <div class="home-blue__section2-clients">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_clients_2', true),'full')[0]; ?>" />
                    </div>
                    <div class="home-blue__section2-clients">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_clients_3', true),'full')[0]; ?>" />
                    </div>
                    <div class="home-blue__section2-clients">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_clients_4', true),'full')[0]; ?>" />
                    </div>
                    <div class="home-blue__section2-clients">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_clients_5', true),'full')[0]; ?>" />
                    </div>
                </div>
            </div>
            <div class="home__section3">
                <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small_headline2', true); ?></p>
                <div class="home__section3-textcolumns">
                    <div class="home__section3-textcolumn">
                        <h2><?php echo get_post_meta(get_the_ID(), 'headline2', true); ?></h2>
                    </div>
                    <div class="home__section3-textcolumn">
                        <h3><?php echo get_post_meta(get_the_ID(), 'title2', true); ?></h3>
                        <p><?php echo get_post_meta(get_the_ID(), 'textarea2', true); ?></p>
                    </div>
                </div>
                <div class="home__section3-imgcolumns">
                    <div class="home__section3-imgcolumn">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_section2_photo_1', true),'full')[0]; ?>" />
                    </div>
                    <div class="home__section3-imgcolumn">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_section2_photo_2', true),'full')[0]; ?>" />
                    </div>
                    <div class="home__section3-imgcolumn">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'mainpage_section2_photo_3', true),'full')[0]; ?>" />
                    </div>
                </div>
                <div class="home__section3-numbers">
                    <div class="numbers">
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
                    <div class="readabout">
                        <a href="<?php echo get_post_meta(get_the_ID(), 'text-read-about2', true); ?>"><span>Read about us</span> &#10230;</a>
                    </div>
                </div>
            </div>
            <div class="home-lightblue">
                <div class="home-lightblue__section4">
                    <div class="home-lightblue__section4-columns">
                        <div class="home-lightblue__section4-column">
                            <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small_headline3', true); ?></p>
                            <h2><?php echo get_post_meta(get_the_ID(), 'headline3', true); ?></h2>
                            <p><?php echo get_post_meta(get_the_ID(), 'textarea3', true); ?></p>
                        </div>
                        <div class="home-lightblue__section4-column">
                            <div class="home-lightblue__section4-rows">
                                <div class="home-lightblue__section4-imgcolumn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/delivery.svg">
                                </div>
                                <div class="home-lightblue__section4-textcolumn">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title31', true); ?></h6>
                                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'text31', true); ?></p>
                                </div>
                            </div>
                            <div class="home-lightblue__section4-rows">
                                <div class="home-lightblue__section4-imgcolumn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/quality.svg">
                                </div>
                                <div class="home-lightblue__section4-textcolumn">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title32', true); ?></h6>
                                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'text32', true); ?></p>
                                </div>
                            </div>
                            <div class="home-lightblue__section4-rows">
                                <div class="home-lightblue__section4-imgcolumn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/assist.svg">
                                </div>
                                <div class="home-lightblue__section4-textcolumn">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title33', true); ?></h6>
                                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'text33', true); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-pink">
                <div class="home-pink__section5">
                    <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small_headline4', true); ?></p>
                    <h2><?php echo get_post_meta(get_the_ID(), 'headline4', true); ?></h2>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'url4', true); ?>" target="_blank">
                        <button>
                            <div class="button">
                                <div class="button__shapes">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shapes.png" />
                                </div>
                                <div class="button__text">
                                    <p><?php echo get_post_meta(get_the_ID(), 'text4', true); ?></p>
                                </div>
                            </div>
                        </button>
                    </a>
                    <div class="home-pink__section5-columns">
                        <div class="home-pink__section5-column">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/technical.svg">
                            <h6><?php echo get_post_meta(get_the_ID(), 'title41', true); ?></h6>
                            <p><?php echo get_post_meta(get_the_ID(), 'text41', true); ?></p>
                            <a href="<?php echo get_post_meta(get_the_ID(), 'text-read-more41', true); ?>"><span>Read more</span> &#10230;</a>
                        </div>
                        <div class="home-pink__section5-column">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/testing.svg">
                            <h6><?php echo get_post_meta(get_the_ID(), 'title42', true); ?></h6>
                            <p><?php echo get_post_meta(get_the_ID(), 'text42', true); ?></p>
                            <a href="<?php echo get_post_meta(get_the_ID(), 'text-read-more42', true); ?>"><span>Read more</span> &#10230;</a>
                        </div>
                        <div class="home-pink__section5-column">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/development.svg">
                            <h6><?php echo get_post_meta(get_the_ID(), 'title43', true); ?></h6>
                            <p><?php echo get_post_meta(get_the_ID(), 'text43', true); ?></p>
                            <a href="<?php echo get_post_meta(get_the_ID(), 'text-read-more43', true); ?>"><span>Read more</span> &#10230;</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home__section6">
                <p class="paragraph-small"><?php echo get_post_meta(get_the_ID(), 'small_headline5', true); ?></p>
                <h2><?php echo get_post_meta(get_the_ID(), 'headline5', true); ?></h2>
                <p><?php echo get_post_meta(get_the_ID(), 'textarea5', true); ?></p>
                <div class="home__section6-columns">
                    <div class="home__section6-column shape">
                        <div class="border">
                            <div class="number">01</div>
                            <div class="border-columns">
                                <div class="border-column">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/discover.svg">
                                </div>
                                <div class="border-column">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title51', true); ?></h6>
                                    <p><?php echo get_post_meta(get_the_ID(), 'text51', true); ?></p>
                                </div>
                            </div>
                        </div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape-row-small.png">
                    </div>
                    <div class="home__section6-column">
                        <div class="border">
                            <div class="number">02</div>
                            <div class="border-columns">
                                <div class="border-column">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/designing.svg">
                                </div>
                                <div class="border-column">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title52', true); ?></h6>
                                    <p><?php echo get_post_meta(get_the_ID(), 'text52', true); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home__section6-column">
                        <div class="border">
                            <div class="number">03</div>
                            <div class="border-columns">
                                <div class="border-column">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/develop.svg">
                                </div>
                                <div class="border-column">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title53', true); ?></h6>
                                    <p><?php echo get_post_meta(get_the_ID(), 'text53', true); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home__section6-column">
                        <div class="border">
                            <div class="number">04</div>
                            <div class="border-columns">
                                <div class="border-column">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/test.svg">
                                </div>
                                <div class="border-column">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title54', true); ?></h6>
                                    <p><?php echo get_post_meta(get_the_ID(), 'text54', true); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home__section6-column">
                        <div class="border">
                            <div class="number">05</div>
                            <div class="border-columns">
                                <div class="border-column">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/deployment.svg">
                                </div>
                                <div class="border-column">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title55', true); ?></h6>
                                    <p><?php echo get_post_meta(get_the_ID(), 'text55', true); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home__section6-column shape">
                        <div class="border">
                            <div class="number">06</div>
                            <div class="border-columns">
                                <div class="border-column">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/maintenance.svg">
                                </div>
                                <div class="border-column">
                                    <h6><?php echo get_post_meta(get_the_ID(), 'title56', true); ?></h6>
                                    <p><?php echo get_post_meta(get_the_ID(), 'text56', true); ?></p>
                                </div>
                            </div>
                        </div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape-row-small.png">
                    </div>
                </div>
            </div>
            <div class="home-lightblue">
                <div class="home-lightblue__section7">
                    <h2>Read our latest blogs & news</h2>
                    <div class="home-lightblue__section7-posts">
                        <?php
                            $args_posts = array( 'posts_per_page' => 2, 'order' => 'DESC','post_status' => 'publish' );
                            $query_posts = new WP_Query($args_posts);
                            if ($query_posts->have_posts()) {
                                while ($query_posts->have_posts()) {
                                    $query_posts->the_post();
                        ?>
                        <div class="home-lightblue__section7-post">
                            <div class="home-lightblue__section7-column">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'third_featured_image', true),'full')[0]; ?>"/>
                                </a>
                            </div>
                            <div class="home-lightblue__section7-columns">
                                <a href="<?php the_permalink(); ?>">
                                    <p class="paragraph-small"><?php echo get_the_date(); ?></p>
                                </a>
                                <a href="<?php the_permalink(); ?>">
                                    <h4><?php the_title(); ?></h4>
                                </a>
                                <a href="<?php the_permalink(); ?>"><span>Read more</span> &#10230;</a>
                            </div>
                        </div>
                        <?php
                                }
                            }
                        ?>
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

<?php
    get_footer();
?>
