<div class="grayblog__section2-post">
    <a href="<?php the_permalink(); ?>">
        <img src="<?php echo wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'third_featured_image', true),'full')[0]; ?>"/>
    </a>
    <div class="grayblog__section2-postcontainer">
        <a href="<?php the_permalink(); ?>">
            <h4><?php the_title(); ?></h4>
        </a>
        <a href="<?php the_permalink(); ?>">
            <p><?php the_excerpt(); ?></p>
        </a>
        <a href="<?php the_permalink(); ?>">
            <span>Read more</span> &#10230;
        </a>
    </div>
</div>