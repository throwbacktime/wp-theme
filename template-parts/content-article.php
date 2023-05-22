<main>
    <section class="blogpost">
        <div class="blogpost__section1">
            <h2 class="blogpost__section1-title"><?php the_title() ?></h2>
            <p class="blogpost__section1-excerpt"><?php the_excerpt(); ?></p>
            <p class="blogpost__section1-date"><?php echo get_the_date(); ?></p>
            <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'second_featured_image', true),'full')[0]; ?>" class="blogpost__section1-header forpc">
            <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'third_featured_image', true),'full')[0]; ?>" class="blogpost__section1-header formobile">
        </div>
        <div class="blogpost__section2">
            <?php the_content() ?>
        </div>
    </section>
</main>