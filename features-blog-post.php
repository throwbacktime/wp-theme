<?php

// Template name: Features
get_header();

?>

<main>
        <section class="blogfeatures">
            <div class="blogfeatures__section1">
                <h2><?php the_title() ?></h2>
            </div>
            <div class="blogfeatures__section2">
                <?php the_content() ?>
            </div>
        </section>
    </main>

<?php get_footer(); ?>