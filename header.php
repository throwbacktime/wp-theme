<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>

</head>

<body>
    <header>
        <div class="menu-btn">
            <span class="menu-btn__burger"></span>
        </div>
        <div class="nav">
            <div class="nav__container">
                <div class="nav__container-logo">
                    <img src="<?php echo wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0]; ?>" alt="Logo">
                </div>
                <?php
                    wp_nav_menu( array( 
                        'theme_location' => 'header-menu', 
                        'container_class' => 'nav__container-menu' )
                    ); 
                ?>
            </div>
        </div>
    </header>