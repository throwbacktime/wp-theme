<?php
    get_header();
?>

<main>
    <section class="blog">
        <div class="blog__section1">
            <h2>Read Recent Post</h2>
            <div class="blog__section1-posts">
                <?php
                  $args = array( 'numberposts' => '2', 'order' => 'DESC','post_status' => 'publish' );
                  $recent_posts = wp_get_recent_posts( $args );
                  foreach( $recent_posts as $recent ) {
                ?>

                <div class="blog__section1-post">
                    <div class="blog__section1-column">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'second_featured_image', true),'full')[0]; ?>" class="forpc" />
                        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'third_featured_image', true),'full')[0]; ?>" class="formobile" />
                    </a>
                    </div>
                    <div class="blog__section1-columns">
                        <a href="<?php the_permalink(); ?>">
                            <p class="paragraph-small"><?php get_the_date( 'F Y', get_the_ID() ); ?></p>
                        </a>
                        <a href="<?php the_permalink(); ?>">
                            <h4><?php the_title(); ?></h4>
                        </a>
                        <a href="<?php the_permalink(); ?>"><span>Read more</span> &#10230;</a>
                    </div>
                </div>

                <?php
                  }
                ?>
            </div>
        </div>
        <div class="grayblog">
            <div class="grayblog__section2">
                <h2>All posts</h2>
                <div class="grayblog__section2-posts">

                <?php

                        if(have_posts()){
                          while(have_posts()){
                            the_post();
                            
                            get_template_part('template-parts/content', 'archive');

                          }
                        }

                ?>

                </div>
            </div>
        </div>
    </section>
</main>

<?php
    get_footer();
?>
