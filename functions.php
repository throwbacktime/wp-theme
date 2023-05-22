<?php

//Inspired by Figma project: https://www.figma.com/community/file/1020703109729818177

function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
}

add_filter('upload_mimes', 'add_file_types_to_uploads');

function theme_custom_logo_setup() {
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'theme_custom_logo_setup');


function template_theme_support(){

    add_theme_support('title-tag');
    add_theme_support('block-templates');
    add_theme_support('post-thumbnails');

}

function custom_header_menu() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
}

add_action( 'init', 'custom_header_menu' );

function custom_footer_menu1() {
    register_nav_menu('footer-menu-1',__( 'Footer Menu 1' ));
}

add_action( 'init', 'custom_footer_menu1' );

function custom_footer_menu2() {
    register_nav_menu('footer-menu-2',__( 'Footer Menu 2' ));
}

add_action( 'init', 'custom_footer_menu2' );

function custom_footer_menu3() {
    register_nav_menu('footer-menu-3',__( 'Footer Menu 3' ));
}

add_action( 'init', 'custom_footer_menu3' );


add_action('after_setup_theme','template_theme_support');


function template_register_styles(){

    $version = wp_get_theme()->get( 'Version' );
    wp_enqueue_style('template-style', get_template_directory_uri() . "/style.css", array(), $version, 'all');

}

add_action('wp_enqueue_scripts', 'template_register_styles');

function template_register_scripts(){

    wp_enqueue_script('template-script', get_template_directory_uri() . "/assets/js/main.js", array(), '1.0', true);
    wp_enqueue_script('jquery-script', get_template_directory_uri() . "/assets/js/jquery.min.js", array( 'jquery' ));

}

add_action('wp_enqueue_scripts', 'template_register_scripts');


function ajax_form_scripts() {
	$translation_array = array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    );
    wp_enqueue_script('subscribe', get_template_directory_uri() . "/assets/js/subscribe.js", array( 'jquery' ));
    wp_localize_script( 'subscribe', 'cpm_object', $translation_array );
}

add_action( 'wp_enqueue_scripts', 'ajax_form_scripts' );

add_action( 'wp_ajax_set_form', 'set_form' );
add_action( 'wp_ajax_nopriv_set_form', 'set_form');


function set_form(){
    global $wpdb;
    $email = $_POST['email'];
    $args = array(
        'post_type' => 'subscribe',
        'posts_per_page' => -1,
    );

    $subscribe_query = new WP_Query($args);
                
    if ($subscribe_query->have_posts()) {
        while ($subscribe_query->have_posts()) {
            $subscribe_query->the_post();
            $table = get_post_meta(get_the_ID(), 'table-name-subscribe', true);
            $column = get_post_meta(get_the_ID(), 'column-name-subscribe', true);
        }
    }

    $wpdb->insert($table, array($column => $email));
    die();
}


function ajax_form_contact_scripts() {
	$translation_array = array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    );
    wp_enqueue_script('contact', get_template_directory_uri() . "/assets/js/contact.js", array( 'jquery' ));
    wp_localize_script( 'contact', 'contact_object', $translation_array );
}

add_action( 'wp_enqueue_scripts', 'ajax_form_contact_scripts' );

add_action( 'wp_ajax_set_form_contact', 'set_form_contact' );
add_action( 'wp_ajax_nopriv_set_form_contact', 'set_form_contact');


function set_form_contact(){
    $subject = 'New Contact Form Submission';
    $body = "<strong>Name:</strong><br>" . $_POST['name'] . "<br><br><strong>Email:</strong><br>" . $_POST['mail'] . "<br><br><strong>Message:</strong><br>" . $_POST['message'];
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $args = array(
        'post_type' => 'contact',
        'posts_per_page' => -1,
    );

    $contact_query = new WP_Query($args);
                
    if ($contact_query->have_posts()) {
        while ($contact_query->have_posts()) {
            $contact_query->the_post();
            $to = get_post_meta(get_the_ID(), 'mail-contact', true);
        }
    }

    wp_mail($to, $subject, $body, $headers);
    die();
}


//Featured images for posts

add_action( 'after_setup_theme', 'custom_postimage_setup' );
function custom_postimage_setup(){
    add_action( 'add_meta_boxes', 'custom_postimage_meta_box' );
    add_action( 'save_post', 'custom_postimage_meta_box_save' );
}

function custom_postimage_meta_box(){
    $post_types = array('post');
    foreach($post_types as $pt){
        add_meta_box('custom_postimage_meta_box',__( 'Banery (1-PC) (2-mobile)', 'yourdomain'),'custom_postimage_meta_box_func',$pt,'side','low');
    }
}

function custom_postimage_meta_box_func($post){

    $meta_keys = array('second_featured_image','third_featured_image');

    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
        <div class="custom_postimage_wrapper" id="<?php echo $meta_key; ?>_wrapper" style="margin-bottom:20px;">
            <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val)[0]:''); ?>" style="width:100%;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt="">
            <a class="addimage button" style="margin-top:10px;margin-bottom:10px;" onclick="custom_postimage_add_image('<?php echo $meta_key; ?>');"><?php _e('Dodaj obrazek','yourdomain'); ?></a><br>
            <a class="removeimage" style="padding-left:10px;color:#a00;cursor:pointer;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="custom_postimage_remove_image('<?php echo $meta_key; ?>');"><?php _e('Usuń obrazek','yourdomain'); ?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php } ?>
    <script>
    function custom_postimage_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        custom_postimage_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Wybierz baner','yourdomain'); ?>',
            button: {
                text: '<?php _e('Wybierz baner','yourdomain'); ?>'
            },
            multiple: false
        });
        custom_postimage_uploader.on('select', function() {

            var attachment = custom_postimage_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        custom_postimage_uploader.on('open', function(){
            var selection = custom_postimage_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        custom_postimage_uploader.open();
        return false;
    }

    function custom_postimage_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
    wp_nonce_field( 'custom_postimage_meta_box', 'custom_postimage_meta_box_nonce' );
}

function custom_postimage_meta_box_save($post_id){

    if ( ! current_user_can( 'edit_posts', $post_id ) ){ return 'not permitted'; }

    if (isset( $_POST['custom_postimage_meta_box_nonce'] ) && wp_verify_nonce($_POST['custom_postimage_meta_box_nonce'],'custom_postimage_meta_box' )){
        $meta_keys = array('second_featured_image','third_featured_image');
        foreach($meta_keys as $meta_key){
            if(isset($_POST[$meta_key]) && intval($_POST[$meta_key])!=''){
                update_post_meta( $post_id, $meta_key, intval($_POST[$meta_key]));
            }else{
                update_post_meta( $post_id, $meta_key, '');
            }
        }
    }
}

//Featured images for posts


// Duplication

add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );

function rd_duplicate_post_link( $actions, $post ) {

	if( ! current_user_can( 'edit_posts' ) ) {
		return $actions;
	}

	$url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'rd_duplicate_post_as_draft',
				'post' => $post->ID,
			),
			'admin.php'
		),
		basename(__FILE__),
		'duplicate_nonce'
	);

	$actions[ 'duplicate' ] = '<a href="' . $url . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

	return $actions;
}

add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );

function rd_duplicate_post_as_draft(){
	if ( empty( $_GET[ 'post' ] ) ) {
		wp_die( 'No post to duplicate has been provided!' );
	}
	if ( ! isset( $_GET[ 'duplicate_nonce' ] ) || ! wp_verify_nonce( $_GET[ 'duplicate_nonce' ], basename( __FILE__ ) ) ) {
		return;
	}
	$post_id = absint( $_GET[ 'post' ] );
	$post = get_post( $post_id );
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	if ( $post ) {
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		$new_post_id = wp_insert_post( $args );

		$taxonomies = get_object_taxonomies( get_post_type( $post ) );
		if( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
				wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
			}
		}

		$post_meta = get_post_meta( $post_id );
		if( $post_meta ) {

			foreach ( $post_meta as $meta_key => $meta_values ) {

				if( '_wp_old_slug' == $meta_key ) {
					continue;
				}

				foreach ( $meta_values as $meta_value ) {
					add_post_meta( $new_post_id, $meta_key, $meta_value );
				}
			}
		}

		wp_safe_redirect(
			add_query_arg(
				array(
					'post_type' => ( 'post' !== get_post_type( $post ) ? get_post_type( $post ) : false ),
					'saved' => 'post_duplication_created'
				),
				admin_url( 'edit.php' )
			)
		);
		exit;

	} else {
		wp_die( 'Post creation failed, could not find original post.' );
	}

}

add_action( 'admin_notices', 'rudr_duplication_admin_notice' );

function rudr_duplication_admin_notice() {
	$screen = get_current_screen();

	if ( 'edit' !== $screen->base ) {
		return;
	}

    if ( isset( $_GET[ 'saved' ] ) && 'post_duplication_created' == $_GET[ 'saved' ] ) {
		 echo '<div class="notice notice-success is-dismissible"><p>Twój element został zduplikowany.</p></div>';
    }
}

// Duplication


// Custom post type - Main page content

function create_main_page_post_type() {
 
    $labels = array(
        'name' => __( 'Main Page' ),
        'singular_name' => __( 'Search' ),
        'all_items'           => __( 'All Pages' ),
        'view_item'           => __( 'Show Content' ),
        'add_new_item'        => __( 'Add New' ),
        'add_new'             => __( 'Add New' ),
        'edit_item'           => __( 'Edit' ),
        'update_item'         => __( 'Update' ),
        'search_items'        => __( 'Search' ),
        'search_items' => __('Search')
    );
   
    $args = array(
        'labels' => $labels,
        'description' => 'Add New Main Page Content',
        'public' => true,
        'has_archive' => true,
        'map_meta_cap' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-admin-page',
        'rewrite' => array('slug' => false),
        'supports' => array(
            'title', 'thumbnail'
        ),
    );
    register_post_type( 'main_page', $args);
   
}

add_action( 'init', 'create_main_page_post_type' );
    
add_action( 'init', function() {
    remove_post_type_support( 'main_page', 'slug' );
});


function custom_section1text() {
    add_meta_box( 'section1text_data', __( 'Section 1', 'section1text-textdomain' ), 'section1text_data_callback', 'main_page' );
}
add_action( 'add_meta_boxes', 'custom_section1text' );

function section1text_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'section1text_nonce' );
    $section1text_stored_meta = get_post_meta( $post->ID );
    $headline_1 = array('headline1');
    $textarea_1 = array('textarea1');
    $button_text_1 = array('text1', 'url1');
    $button_placeholder = array('Your text', 'Your URL');

    if ( isset ( $section1text_stored_meta[$headline_1[0]] ) ) {
        $default_headline_1 = $section1text_stored_meta[$headline_1[0]];
    }

    if ( isset ( $section1text_stored_meta[$textarea_1[0]] ) ) {
        $default_textarea_1 = $section1text_stored_meta[$textarea_1[0]];
    }

    if ( isset ( $section1text_stored_meta[$button_text_1[0]] ) ) {
        $default_button_text_1_1 = $section1text_stored_meta[$button_text_1[0]];
    }

    if ( isset ( $section1text_stored_meta[$button_text_1[1]] ) ) {
        $default_button_text_1_2 = $section1text_stored_meta[$button_text_1[1]];
    }
?>

    <p><b>Headline</b></p>
    <input type="text" style="width:100%;" name="<?php echo $headline_1[0] ?>" id="<?php echo $headline_1[0] ?>" value="<?php echo esc_attr( $default_headline_1[0] ); ?>" />
    <p><b>Text</b></p>
    <textarea style="width:100%; min-height: 100px;" name="<?php echo $textarea_1[0] ?>" id="<?php echo $textarea_1[0] ?>"><?php echo esc_attr( $default_textarea_1[0] ); ?></textarea>
    <p><b>Button</b></p>
    <div style="display: flex; flex-direction: row; gap: 20px;">
        <div style="width: 50%">
            <input type="text" style="width:100%;" name="<?php echo $button_text_1[0] ?>" id="<?php echo $button_text_1[0] ?>" value="<?php echo esc_attr( $default_button_text_1_1[0] ); ?>" placeholder="<?php echo $button_placeholder[0] ?>"/>
        </div>
        <div style="width: 50%">
            <input type="text" style="width:100%;" name="<?php echo $button_text_1[1] ?>" id="<?php echo $button_text_1[1] ?>" value="<?php echo esc_attr( $default_button_text_1_2[0] ); ?>" placeholder="<?php echo $button_placeholder[1] ?>"/>
        </div>
    </div>

<?php
}

function section1text_data_save( $post_id ) {

    $headline_1 = array('headline1');
    $textarea_1 = array('textarea1');
    $button_text_1 = array('text1', 'url1');
 
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'section1text_nonce' ] ) && wp_verify_nonce( $_POST[ 'section1text_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    foreach($headline_1 as $headlines_1){
        if ( isset( $_POST[ $headlines_1 ] ) ) {
            update_post_meta( $post_id, $headlines_1, $_POST[ $headlines_1 ] );
        }
    } 

    foreach($textarea_1 as $textareas_1){
        if ( isset( $_POST[ $textareas_1 ] ) ) {
            update_post_meta( $post_id, $textareas_1, $_POST[ $textareas_1 ] );
        }
    } 

    foreach($button_text_1 as $button_texts_1){
        if ( isset( $_POST[ $button_texts_1 ] ) ) {
            update_post_meta( $post_id, $button_texts_1, $_POST[ $button_texts_1 ] );
        }
    } 
}
add_action( 'save_post', 'section1text_data_save' );


add_action( 'after_setup_theme', 'mainpage_section1_photo_setup' );
function mainpage_section1_photo_setup(){
    add_action( 'save_post', 'mainpage_section1_photo_meta_box_save' );
}

function mainpage_section1_photo_meta_box(){
    add_meta_box('mainpage_section1_photo_meta_box',__( 'Section 1 - photo', 'yourdomain'),'mainpage_section1_photo_meta_box_func','main_page');
}

add_action( 'add_meta_boxes', 'mainpage_section1_photo_meta_box' );

function mainpage_section1_photo_meta_box_func($post){

    $meta_keys = array('mainpage_section1_photo');
    ?>
    <div style="--grid-layout-gap: 10px; --grid-column-count: 6; --grid-item--min-width: 200px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
    <?php
    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
        <div class="mainpage_section1_photo_wrapper" id="<?php echo $meta_key; ?>_wrapper">
            <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val)[0]:''); ?>" style="max-width:300px;width:100%;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt="">
            <a class="addimage button" style="margin-top:10px;margin-bottom:10px;" onclick="mainpage_section1_photo_add_image('<?php echo $meta_key; ?>');"><?php _e('Add image','yourdomain'); ?></a><br>
            <a class="removeimage" style="padding-left:10px;color:#a00;cursor:pointer;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="mainpage_section1_photo_remove_image('<?php echo $meta_key; ?>');"><?php _e('Delete image','yourdomain'); ?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php } ?>
    </div>
    <script>
    function mainpage_section1_photo_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        mainpage_section1_photo_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select photo','yourdomain'); ?>',
            button: {
                text: '<?php _e('Select photo','yourdomain'); ?>'
            },
            multiple: false
        });
        mainpage_section1_photo_uploader.on('select', function() {

            var attachment = mainpage_section1_photo_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        mainpage_section1_photo_uploader.on('open', function(){
            var selection = mainpage_section1_photo_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        mainpage_section1_photo_uploader.open();
        return false;
    }

    function mainpage_section1_photo_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
    wp_nonce_field( 'mainpage_section1_photo_meta_box', 'mainpage_section1_photo_meta_box_nonce' );
}

function mainpage_section1_photo_meta_box_save($post_id){

    if ( ! current_user_can( 'edit_posts', $post_id ) ){ return 'not permitted'; }

    if (isset( $_POST['mainpage_section1_photo_meta_box_nonce'] ) && wp_verify_nonce($_POST['mainpage_section1_photo_meta_box_nonce'],'mainpage_section1_photo_meta_box' )){

        $meta_keys = array('mainpage_section1_photo');
        foreach($meta_keys as $meta_key){
            if(isset($_POST[$meta_key]) && intval($_POST[$meta_key])!=''){
                update_post_meta( $post_id, $meta_key, intval($_POST[$meta_key]));
            }else{
                update_post_meta( $post_id, $meta_key, '');
            }
        }
    }
}


function custom_clients() {
    add_meta_box( 'clients_data', __( 'Partners', 'clients-textdomain' ), 'clients_data_callback', 'main_page' );
}
add_action( 'add_meta_boxes', 'custom_clients' );

function clients_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'clients_nonce' );
    $clients_stored_meta = get_post_meta( $post->ID );
    $client = array('client');
    $work = array('work');

    if ( isset ( $clients_stored_meta[$client[0]] ) ) {
        $default_client = $clients_stored_meta[$client[0]];
    }

    if ( isset ( $clients_stored_meta[$work[0]] ) ) {
        $default_work = $clients_stored_meta[$work[0]];
    }
?>

    <p><b>Small Headline</b></p>
    <input type="text" style="width:100%;" name="<?php echo $client[0] ?>" id="<?php echo $client[0] ?>" value="<?php echo esc_attr( $default_client[0] ); ?>" />
    <p><b>Title</b></p>
    <input type="text" style="width:100%;" name="<?php echo $work[0] ?>" id="<?php echo $work[0] ?>" value="<?php echo esc_attr( $default_work[0] ); ?>"/>

<?php
}

function clients_data_save( $post_id ) {

    $client = array('client');
    $work = array('work');
 
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'clients_nonce' ] ) && wp_verify_nonce( $_POST[ 'clients_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    foreach($client as $clients){
        if ( isset( $_POST[ $clients ] ) ) {
            update_post_meta( $post_id, $clients, $_POST[ $clients ] );
        }
    }

    foreach($work as $works){
        if ( isset( $_POST[ $works ] ) ) {
            update_post_meta( $post_id, $works, $_POST[ $works ] );
        }
    } 
}
add_action( 'save_post', 'clients_data_save' );


add_action( 'after_setup_theme', 'mainpage_clients_setup' );
function mainpage_clients_setup(){
    add_action( 'save_post', 'mainpage_clients_meta_box_save' );
}

function mainpage_clients_meta_box(){
    add_meta_box('mainpage_clients_meta_box',__( 'Partners - logos', 'yourdomain'),'mainpage_clients_meta_box_func','main_page');
}

add_action( 'add_meta_boxes', 'mainpage_clients_meta_box' );

function mainpage_clients_meta_box_func($post){

    $meta_keys = array('mainpage_clients_1', 'mainpage_clients_2', 'mainpage_clients_3', 'mainpage_clients_4', 'mainpage_clients_5');
    ?>
    <div style="--grid-layout-gap: 10px; --grid-column-count: 6; --grid-item--min-width: 200px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
    <?php
    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
        <div class="mainpage_clients_wrapper" id="<?php echo $meta_key; ?>_wrapper">
            <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val)[0]:''); ?>" style="max-width:300px;width:100%;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt="">
            <a class="addimage button" style="margin-top:10px;margin-bottom:10px;" onclick="mainpage_clients_add_image('<?php echo $meta_key; ?>');"><?php _e('Add image','yourdomain'); ?></a><br>
            <a class="removeimage" style="padding-left:10px;color:#a00;cursor:pointer;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="mainpage_clients_remove_image('<?php echo $meta_key; ?>');"><?php _e('Delete image','yourdomain'); ?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php } ?>
    </div>
    <script>
    function mainpage_clients_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        mainpage_clients_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select photo','yourdomain'); ?>',
            button: {
                text: '<?php _e('Select photo','yourdomain'); ?>'
            },
            multiple: false
        });
        mainpage_clients_uploader.on('select', function() {

            var attachment = mainpage_clients_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        mainpage_clients_uploader.on('open', function(){
            var selection = mainpage_clients_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        mainpage_clients_uploader.open();
        return false;
    }

    function mainpage_clients_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
    wp_nonce_field( 'mainpage_clients_meta_box', 'mainpage_clients_meta_box_nonce' );
}

function mainpage_clients_meta_box_save($post_id){

    if ( ! current_user_can( 'edit_posts', $post_id ) ){ return 'not permitted'; }

    if (isset( $_POST['mainpage_clients_meta_box_nonce'] ) && wp_verify_nonce($_POST['mainpage_clients_meta_box_nonce'],'mainpage_clients_meta_box' )){

        $meta_keys = array('mainpage_clients_1', 'mainpage_clients_2', 'mainpage_clients_3', 'mainpage_clients_4', 'mainpage_clients_5');
        foreach($meta_keys as $meta_key){
            if(isset($_POST[$meta_key]) && intval($_POST[$meta_key])!=''){
                update_post_meta( $post_id, $meta_key, intval($_POST[$meta_key]));
            }else{
                update_post_meta( $post_id, $meta_key, '');
            }
        }
    }
}


function custom_section2text() {
    add_meta_box( 'section2text_data', __( 'Section 2', 'section2text-textdomain' ), 'section2text_data_callback', 'main_page' );
}
add_action( 'add_meta_boxes', 'custom_section2text' );

function section2text_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'section2text_nonce' );
    $section2text_stored_meta = get_post_meta( $post->ID );
    $textarea_2 = array('textarea2');
    $meta_section2texts = array(array('Small Headline','small_headline2'),array('Headline','headline2'),array('Title','title2'),array('Number1','project2'),array('Number2','professional2'),array('Number3','happy2'),array('Number4','experience2'),array('Text under number1','text-project2'),array('Text under number2','text-professional2'),array('Text under number3','text-happy2'),array('Text under number4','text-experience2'),array('URL for Read about us','text-read-about2'));
    
    if ( isset ( $section2text_stored_meta[$textarea_2[0]] ) ) {
        $default_textarea_2 = $section2text_stored_meta[$textarea_2[0]];
    }

    ?>
        <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_section2texts as $meta_section2text){ ?>
                <div>
                    <p><b><?php echo $meta_section2text[0] ?></b></p>
                    <?php 
                        if ( isset ( $section2text_stored_meta[$meta_section2text[1]] ) ) {
                            $default_input = $section2text_stored_meta[$meta_section2text[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_section2text[1] ?>" id="<?php echo $meta_section2text[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
        </div>
        <p><b>Text under title</b></p>
        <textarea style="width:100%; min-height: 100px;" name="<?php echo $textarea_2[0] ?>" id="<?php echo $textarea_2[0] ?>"><?php echo esc_attr( $default_textarea_2[0] ); ?></textarea>
    <?php
}

function section2text_data_save( $post_id ) {

    $textarea_2 = array('textarea2');
    $meta_section2texts = array(array('Small Headline','small_headline2'),array('Headline','headline2'),array('Title','title2'),array('Number1','project2'),array('Number2','professional2'),array('Number3','happy2'),array('Number4','experience2'),array('Text under number1','text-project2'),array('Text under number2','text-professional2'),array('Text under number3','text-happy2'),array('Text under number4','text-experience2'),array('URL for Read about us','text-read-about2'));

    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'section2text_nonce' ] ) && wp_verify_nonce( $_POST[ 'section2text_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    foreach($textarea_2 as $textareas_2){
        if ( isset( $_POST[ $textareas_2 ] ) ) {
            update_post_meta( $post_id, $textareas_2, $_POST[ $textareas_2 ] );
        }
    } 
 
    foreach($meta_section2texts as $meta_section2text){
        if( isset( $_POST[ $meta_section2text[1] ] ) ) {
            update_post_meta( $post_id, $meta_section2text[1], $_POST[ $meta_section2text[1] ] );
        }
    }
 
}
add_action( 'save_post', 'section2text_data_save' );


add_action( 'after_setup_theme', 'mainpage_section2_photo_setup' );
function mainpage_section2_photo_setup(){
    add_action( 'save_post', 'mainpage_section2_photo_meta_box_save' );
}

function mainpage_section2_photo_meta_box(){
    add_meta_box('mainpage_section2_photo_meta_box',__( 'Section 2 - photos, duplicate on "About" subpage', 'yourdomain'),'mainpage_section2_photo_meta_box_func','main_page');
}

add_action( 'add_meta_boxes', 'mainpage_section2_photo_meta_box' );

function mainpage_section2_photo_meta_box_func($post){

    $meta_keys = array('mainpage_section2_photo_1', 'mainpage_section2_photo_2', 'mainpage_section2_photo_3');
    ?>
    <div style="--grid-layout-gap: 10px; --grid-column-count: 6; --grid-item--min-width: 200px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
    <?php
    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
        <div class="mainpage_section2_photo_wrapper" id="<?php echo $meta_key; ?>_wrapper">
            <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val)[0]:''); ?>" style="max-width:300px;width:100%;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt="">
            <a class="addimage button" style="margin-top:10px;margin-bottom:10px;" onclick="mainpage_section2_photo_add_image('<?php echo $meta_key; ?>');"><?php _e('Add image','yourdomain'); ?></a><br>
            <a class="removeimage" style="padding-left:10px;color:#a00;cursor:pointer;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="mainpage_section2_photo_remove_image('<?php echo $meta_key; ?>');"><?php _e('Delete image','yourdomain'); ?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php } ?>
    </div>
    <script>
    function mainpage_section2_photo_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        mainpage_section2_photo_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select photo','yourdomain'); ?>',
            button: {
                text: '<?php _e('Select photo','yourdomain'); ?>'
            },
            multiple: false
        });
        mainpage_section2_photo_uploader.on('select', function() {

            var attachment = mainpage_section2_photo_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        mainpage_section2_photo_uploader.on('open', function(){
            var selection = mainpage_section2_photo_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        mainpage_section2_photo_uploader.open();
        return false;
    }

    function mainpage_section2_photo_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
    wp_nonce_field( 'mainpage_section2_photo_meta_box', 'mainpage_section2_photo_meta_box_nonce' );
}

function mainpage_section2_photo_meta_box_save($post_id){

    if ( ! current_user_can( 'edit_posts', $post_id ) ){ return 'not permitted'; }

    if (isset( $_POST['mainpage_section2_photo_meta_box_nonce'] ) && wp_verify_nonce($_POST['mainpage_section2_photo_meta_box_nonce'],'mainpage_section2_photo_meta_box' )){

        $meta_keys = array('mainpage_section2_photo_1', 'mainpage_section2_photo_2', 'mainpage_section2_photo_3');
        foreach($meta_keys as $meta_key){
            if(isset($_POST[$meta_key]) && intval($_POST[$meta_key])!=''){
                update_post_meta( $post_id, $meta_key, intval($_POST[$meta_key]));
            }else{
                update_post_meta( $post_id, $meta_key, '');
            }
        }
    }
}


function custom_section3text() {
    add_meta_box( 'section3text_data', __( 'Section 3, duplicate on "About" subpage', 'section3text-textdomain' ), 'section3text_data_callback', 'main_page' );
}
add_action( 'add_meta_boxes', 'custom_section3text' );

function section3text_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'section3text_nonce' );
    $section3text_stored_meta = get_post_meta( $post->ID );
    $textarea_3 = array('textarea3');
    $meta_section3texts = array(array('Small Headline','small_headline3'),array('Headline','headline3'),array('Title1','title31'),array('Text1','text31'),array('Title2','title32'),array('Text2','text32'),array('Title3','title33'),array('Text3','text33'));
    
    if ( isset ( $section3text_stored_meta[$textarea_3[0]] ) ) {
        $default_textarea_3 = $section3text_stored_meta[$textarea_3[0]];
    }
    
    ?>
        <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_section3texts as $meta_section3text){ ?>
                <div>
                    <p><b><?php echo $meta_section3text[0] ?></b></p>
                    <?php 
                        if ( isset ( $section3text_stored_meta[$meta_section3text[1]] ) ) {
                            $default_input = $section3text_stored_meta[$meta_section3text[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_section3text[1] ?>" id="<?php echo $meta_section3text[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
        </div>
        <p><b>Text under headline</b></p>
        <textarea style="width:100%; min-height: 100px;" name="<?php echo $textarea_3[0] ?>" id="<?php echo $textarea_3[0] ?>"><?php echo esc_attr( $default_textarea_3[0] ); ?></textarea>
    <?php
}

function section3text_data_save( $post_id ) {

    $textarea_3 = array('textarea3');
    $meta_section3texts = array(array('Small Headline','small_headline3'),array('Headline','headline3'),array('Title1','title31'),array('Text1','text31'),array('Title2','title32'),array('Text2','text32'),array('Title3','title33'),array('Text3','text33'));

    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'section3text_nonce' ] ) && wp_verify_nonce( $_POST[ 'section3text_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    foreach($textarea_3 as $textareas_3){
        if ( isset( $_POST[ $textareas_3 ] ) ) {
            update_post_meta( $post_id, $textareas_3, $_POST[ $textareas_3 ] );
        }
    } 
 
    foreach($meta_section3texts as $meta_section3text){
        if( isset( $_POST[ $meta_section3text[1] ] ) ) {
            update_post_meta( $post_id, $meta_section3text[1], $_POST[ $meta_section3text[1] ] );
        }
    }
 
}
add_action( 'save_post', 'section3text_data_save' );


function custom_section4text() {
    add_meta_box( 'section4text_data', __( 'Section 4', 'section4text-textdomain' ), 'section4text_data_callback', 'main_page' );
}
add_action( 'add_meta_boxes', 'custom_section4text' );

function section4text_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'section4text_nonce' );
    $section4text_stored_meta = get_post_meta( $post->ID );
    $small_headline_4 = array('small_headline4');
    $headline_4 = array('headline4');
    $button_text_4 = array('text4', 'url4');
    $button_placeholder = array('Your text', 'Your URL');
    $meta_section4texts = array(array('Title1','title41'),array('Text1','text41'),array('Title2','title42'),array('Text2','text42'),array('Title3','title43'),array('Text3','text43'),array('URL for Read more 1','text-read-more41'),array('URL for Read more 2','text-read-more42'),array('URL for Read more 3','text-read-more43'));

    if ( isset ( $section4text_stored_meta[$small_headline_4[0]] ) ) {
        $default_small_headline_4 = $section4text_stored_meta[$small_headline_4[0]];
    }

    if ( isset ( $section4text_stored_meta[$headline_4[0]] ) ) {
        $default_headline_4 = $section4text_stored_meta[$headline_4[0]];
    }

    if ( isset ( $section4text_stored_meta[$button_text_4[0]] ) ) {
        $default_button_text_4_1 = $section4text_stored_meta[$button_text_4[0]];
    }

    if ( isset ( $section4text_stored_meta[$button_text_4[1]] ) ) {
        $default_button_text_4_2 = $section4text_stored_meta[$button_text_4[1]];
    }
?>

    <p><b>Small Headline</b></p>
    <input type="text" style="width:100%;" name="<?php echo $small_headline_4[0] ?>" id="<?php echo $small_headline_4[0] ?>" value="<?php echo esc_attr( $default_small_headline_4[0] ); ?>" />
    <p><b>Headline</b></p>
    <input type="text" style="width:100%;" name="<?php echo $headline_4[0] ?>" id="<?php echo $headline_4[0] ?>" value="<?php echo esc_attr( $default_headline_4[0] ); ?>" />
    <p><b>Button</b></p>
    <div style="display: flex; flex-direction: row; gap: 20px;">
        <div style="width: 50%">
            <input type="text" style="width:100%;" name="<?php echo $button_text_4[0] ?>" id="<?php echo $button_text_4[0] ?>" value="<?php echo esc_attr( $default_button_text_4_1[0] ); ?>" placeholder="<?php echo $button_placeholder[0] ?>"/>
        </div>
        <div style="width: 50%">
            <input type="text" style="width:100%;" name="<?php echo $button_text_4[1] ?>" id="<?php echo $button_text_4[1] ?>" value="<?php echo esc_attr( $default_button_text_4_2[0] ); ?>" placeholder="<?php echo $button_placeholder[1] ?>"/>
        </div>
    </div>
    <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_section4texts as $meta_section4text){ ?>
                <div>
                    <p><b><?php echo $meta_section4text[0] ?></b></p>
                    <?php 
                        if ( isset ( $section4text_stored_meta[$meta_section4text[1]] ) ) {
                            $default_input = $section4text_stored_meta[$meta_section4text[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_section4text[1] ?>" id="<?php echo $meta_section4text[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
        </div>

<?php
}

function section4text_data_save( $post_id ) {

    $small_headline_4 = array('small_headline4');
    $headline_4 = array('headline4');
    $button_text_4 = array('text4', 'url4');
    $meta_section4texts = array(array('Title1','title41'),array('Text1','text41'),array('Title2','title42'),array('Text2','text42'),array('Title3','title43'),array('Text3','text43'),array('URL for Read more 1','text-read-more41'),array('URL for Read more 2','text-read-more42'),array('URL for Read more 3','text-read-more43'));
 
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'section4text_nonce' ] ) && wp_verify_nonce( $_POST[ 'section4text_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    foreach($small_headline_4 as $small_headlines_4){
        if ( isset( $_POST[ $small_headlines_4 ] ) ) {
            update_post_meta( $post_id, $small_headlines_4, $_POST[ $small_headlines_4 ] );
        }
    } 

    foreach($headline_4 as $headlines_4){
        if ( isset( $_POST[ $headlines_4 ] ) ) {
            update_post_meta( $post_id, $headlines_4, $_POST[ $headlines_4 ] );
        }
    } 

    foreach($button_text_4 as $button_texts_4){
        if ( isset( $_POST[ $button_texts_4 ] ) ) {
            update_post_meta( $post_id, $button_texts_4, $_POST[ $button_texts_4 ] );
        }
    }

    foreach($meta_section4texts as $meta_section4text){
        if( isset( $_POST[ $meta_section4text[1] ] ) ) {
            update_post_meta( $post_id, $meta_section4text[1], $_POST[ $meta_section4text[1] ] );
        }
    }
}
add_action( 'save_post', 'section4text_data_save' );


function custom_section5text() {
    add_meta_box( 'section5text_data', __( 'Section 5', 'section5text-textdomain' ), 'section5text_data_callback', 'main_page' );
}
add_action( 'add_meta_boxes', 'custom_section5text' );

function section5text_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'section5text_nonce' );
    $section5text_stored_meta = get_post_meta( $post->ID );
    $textarea_5 = array('textarea5');
    $meta_section5texts = array(array('Small headline','small_headline5'),array('Headline','headline5'),array('Title1','title51'),array('Text1','text51'),array('Title2','title52'),array('Text2','text52'),array('Title3','title53'),array('Text3','text53'),array('Title4','title54'),array('Text4','text54'),array('Title5','title55'),array('Text5','text55'),array('Title6','title56'),array('Text6','text56'));

    if ( isset ( $section5text_stored_meta[$textarea_5[0]] ) ) {
        $default_textarea_5 = $section5text_stored_meta[$textarea_5[0]];
    }
?>

    <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_section5texts as $meta_section5text){ ?>
                <div>
                    <p><b><?php echo $meta_section5text[0] ?></b></p>
                    <?php 
                        if ( isset ( $section5text_stored_meta[$meta_section5text[1]] ) ) {
                            $default_input = $section5text_stored_meta[$meta_section5text[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_section5text[1] ?>" id="<?php echo $meta_section5text[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
    </div>
    <p><b>Text under Headline</b></p>
    <textarea style="width:100%; min-height: 100px;" name="<?php echo $textarea_5[0] ?>" id="<?php echo $textarea_5[0] ?>"><?php echo esc_attr( $default_textarea_5[0] ); ?></textarea>

<?php
}

function section5text_data_save( $post_id ) {

    $textarea_5 = array('textarea5');
    $meta_section5texts = array(array('Small headline','small_headline5'),array('Headline','headline5'),array('Title1','title51'),array('Text1','text51'),array('Title2','title52'),array('Text2','text52'),array('Title3','title53'),array('Text3','text53'),array('Title4','title54'),array('Text4','text54'),array('Title5','title55'),array('Text5','text55'),array('Title6','title56'),array('Text6','text56'));
 
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'section5text_nonce' ] ) && wp_verify_nonce( $_POST[ 'section5text_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    foreach($textarea_5 as $textareas_5){
        if ( isset( $_POST[ $textareas_5 ] ) ) {
            update_post_meta( $post_id, $textareas_5, $_POST[ $textareas_5 ] );
        }
    } 

    foreach($meta_section5texts as $meta_section5text){
        if( isset( $_POST[ $meta_section5text[1] ] ) ) {
            update_post_meta( $post_id, $meta_section5text[1], $_POST[ $meta_section5text[1] ] );
        }
    }
}
add_action( 'save_post', 'section5text_data_save' );

// Custom post type - Main page content


// Custom post type - Footer content

function create_footer_post_type() {
 
    $labels = array(
        'name' => __( 'Footers' ),
        'singular_name' => __( 'Search' ),
        'all_items'           => __( 'All Pages' ),
        'view_item'           => __( 'Show Content' ),
        'add_new_item'        => __( 'Add New' ),
        'add_new'             => __( 'Add New' ),
        'edit_item'           => __( 'Edit' ),
        'update_item'         => __( 'Update' ),
        'search_items'        => __( 'Search' ),
        'search_items' => __('Search')
    );
   
    $args = array(
        'labels' => $labels,
        'description' => 'Add New Footer Content',
        'public' => true,
        'has_archive' => true,
        'map_meta_cap' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-admin-page',
        'rewrite' => array('slug' => false),
        'supports' => array(
            'title', 'thumbnail'
        ),
    );
    register_post_type( 'footer', $args);
   
}

add_action( 'init', 'create_footer_post_type' );
    
add_action( 'init', function() {
    remove_post_type_support( 'footer', 'slug' );
});

function custom_footer() {
    add_meta_box( 'footer_data', __( 'Footer', 'footer-textdomain' ), 'footer_data_callback', 'footer' );
}
add_action( 'add_meta_boxes', 'custom_footer' );

function footer_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'footer_nonce' );
    $footer_stored_meta = get_post_meta( $post->ID );
    $meta_footers = array(array('Headline','headline-footer'),array('Title','title-footer'),array('Phone Number','phone-footer'),array('Mail','mail-footer'),array('Address','address-footer'),array('Contact us link - Mail','contact-us-footer'),array('Facebook URL','facebook-footer'),array('Twitter URL','twitter-footer'),array('Instagram URL','instagram-footer'),array('LinkedIn URL','linkedin-footer'),array('Copyrights Text','copyrights-footer'));   
    ?>
        <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_footers as $meta_footer){ ?>
                <div>
                    <p><b><?php echo $meta_footer[0] ?></b></p>
                    <?php 
                        if ( isset ( $footer_stored_meta[$meta_footer[1]] ) ) {
                            $default_input = $footer_stored_meta[$meta_footer[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_footer[1] ?>" id="<?php echo $meta_footer[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
        </div>
    <?php
}

function footer_data_save( $post_id ) {

    $meta_footers = array(array('Headline','headline-footer'),array('Title','title-footer'),array('Phone Number','phone-footer'),array('Mail','mail-footer'),array('Address','address-footer'),array('Contact us link - Mail','contact-us-footer'),array('Facebook URL','facebook-footer'),array('Twitter URL','twitter-footer'),array('Instagram URL','instagram-footer'),array('LinkedIn URL','linkedin-footer'),array('Copyrights Text','copyrights-footer'));

    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'footer_nonce' ] ) && wp_verify_nonce( $_POST[ 'footer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    foreach($meta_footers as $meta_footer){
        if( isset( $_POST[ $meta_footer[1] ] ) ) {
            update_post_meta( $post_id, $meta_footer[1], $_POST[ $meta_footer[1] ] );
        }
    }
 
}
add_action( 'save_post', 'footer_data_save' );


add_action( 'after_setup_theme', 'footer_photo_setup' );
function footer_photo_setup(){
    add_action( 'save_post', 'footer_photo_meta_box_save' );
}

function footer_photo_meta_box(){
    add_meta_box('footer_photo_meta_box',__( 'Footer - logo', 'yourdomain'),'footer_photo_meta_box_func','footer');
}

add_action( 'add_meta_boxes', 'footer_photo_meta_box' );

function footer_photo_meta_box_func($post){

    $meta_keys = array('footer_photo_1');
    ?>
    <div style="--grid-layout-gap: 10px; --grid-column-count: 6; --grid-item--min-width: 200px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
    <?php
    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
        <div class="footer_photo_wrapper" id="<?php echo $meta_key; ?>_wrapper">
            <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val)[0]:''); ?>" style="max-width:300px;width:100%;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt="">
            <a class="addimage button" style="margin-top:10px;margin-bottom:10px;" onclick="footer_photo_add_image('<?php echo $meta_key; ?>');"><?php _e('Add image','yourdomain'); ?></a><br>
            <a class="removeimage" style="padding-left:10px;color:#a00;cursor:pointer;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="footer_photo_remove_image('<?php echo $meta_key; ?>');"><?php _e('Delete image','yourdomain'); ?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php } ?>
    </div>
    <script>
    function footer_photo_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        footer_photo_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select photo','yourdomain'); ?>',
            button: {
                text: '<?php _e('Select photo','yourdomain'); ?>'
            },
            multiple: false
        });
        footer_photo_uploader.on('select', function() {

            var attachment = footer_photo_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        footer_photo_uploader.on('open', function(){
            var selection = footer_photo_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        footer_photo_uploader.open();
        return false;
    }

    function footer_photo_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
    wp_nonce_field( 'footer_photo_meta_box', 'footer_photo_meta_box_nonce' );
}

function footer_photo_meta_box_save($post_id){

    if ( ! current_user_can( 'edit_posts', $post_id ) ){ return 'not permitted'; }

    if (isset( $_POST['footer_photo_meta_box_nonce'] ) && wp_verify_nonce($_POST['footer_photo_meta_box_nonce'],'footer_photo_meta_box' )){

        $meta_keys = array('footer_photo_1');
        foreach($meta_keys as $meta_key){
            if(isset($_POST[$meta_key]) && intval($_POST[$meta_key])!=''){
                update_post_meta( $post_id, $meta_key, intval($_POST[$meta_key]));
            }else{
                update_post_meta( $post_id, $meta_key, '');
            }
        }
    }
}

// Custom post type - Footer content


// Custom post type - Subscribe form

function create_subscribe_post_type() {
 
    $labels = array(
        'name' => __( 'Subscribe Form' ),
        'singular_name' => __( 'Search' ),
        'all_items'           => __( 'All Pages' ),
        'view_item'           => __( 'Show Content' ),
        'add_new_item'        => __( 'Add New' ),
        'add_new'             => __( 'Add New' ),
        'edit_item'           => __( 'Edit' ),
        'update_item'         => __( 'Update' ),
        'search_items'        => __( 'Search' ),
        'search_items' => __('Search')
    );
   
    $args = array(
        'labels' => $labels,
        'description' => 'Add New Subscribe Database',
        'public' => true,
        'has_archive' => true,
        'map_meta_cap' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-admin-page',
        'rewrite' => array('slug' => false),
        'supports' => array(
            'title'
        ),
    );
    register_post_type( 'subscribe', $args);
   
}

add_action( 'init', 'create_subscribe_post_type' );
    
add_action( 'init', function() {
    remove_post_type_support( 'subscribe', 'slug' );
});


function custom_subscribe() {
    add_meta_box( 'subscribe_data', __( 'Database - your table and column names', 'subscribe-textdomain' ), 'subscribe_data_callback', 'subscribe' );
}
add_action( 'add_meta_boxes', 'custom_subscribe' );

function subscribe_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'subscribe_nonce' );
    $subscribe_stored_meta = get_post_meta( $post->ID );
    $meta_subscribes = array(array('Table name','table-name-subscribe'),array('Column name in your table, it must be the same here and in database','column-name-subscribe'));
    ?>
        <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_subscribes as $meta_subscribe){ ?>
                <div>
                    <p><b><?php echo $meta_subscribe[0] ?></b></p>
                    <?php 
                        if ( isset ( $subscribe_stored_meta[$meta_subscribe[1]] ) ) {
                            $default_input = $subscribe_stored_meta[$meta_subscribe[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_subscribe[1] ?>" id="<?php echo $meta_subscribe[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
        </div>
    <?php
}

function subscribe_data_save( $post_id ) {

    $meta_subscribes = array(array('Table Name','table-name-subscribe'),array('Column Name','column-name-subscribe'));

    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'subscribe_nonce' ] ) && wp_verify_nonce( $_POST[ 'subscribe_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    foreach($meta_subscribes as $meta_subscribe){
        if( isset( $_POST[ $meta_subscribe[1] ] ) ) {
            update_post_meta( $post_id, $meta_subscribe[1], $_POST[ $meta_subscribe[1] ] );
        }
    }
 
}
add_action( 'save_post', 'subscribe_data_save' );

// Custom post type - Subscribe form


// Custom post type - About Us

function create_aboutus_post_type() {
 
    $labels = array(
        'name' => __( 'About Us' ),
        'singular_name' => __( 'Search' ),
        'all_items'           => __( 'All Pages' ),
        'view_item'           => __( 'Show Content' ),
        'add_new_item'        => __( 'Add New' ),
        'add_new'             => __( 'Add New' ),
        'edit_item'           => __( 'Edit' ),
        'update_item'         => __( 'Update' ),
        'search_items'        => __( 'Search' ),
        'search_items' => __('Search')
    );
   
    $args = array(
        'labels' => $labels,
        'description' => 'Add New About Us',
        'public' => true,
        'has_archive' => true,
        'map_meta_cap' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-admin-page',
        'rewrite' => array('slug' => false),
        'supports' => array(
            'title', 'thumbnail'
        ),
    );
    register_post_type( 'aboutus', $args);
   
}

add_action( 'init', 'create_aboutus_post_type' );
    
add_action( 'init', function() {
    remove_post_type_support( 'aboutus', 'slug' );
});


function custom_aboutus() {
    add_meta_box( 'aboutus_data', __( 'About Us', 'aboutus-textdomain' ), 'aboutus_data_callback', 'aboutus' );
}
add_action( 'add_meta_boxes', 'custom_aboutus' );

function aboutus_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'aboutus_nonce' );
    $aboutus_stored_meta = get_post_meta( $post->ID );
    $meta_aboutuss = array(array('Small headline 1','small-headline-aboutus1'), array('Headline 1','headline-aboutus1'), array('Text 1','text-aboutus1'), array('Small headline 2','small-headline-aboutus2'), array('Headline 2','headline-aboutus2'), array('Text 2','text-aboutus2'), array('Small headline 3','small-headline-aboutus3'), array('Headline 3','headline-aboutus3'), array('Text 3','text-aboutus3'), array('Small headline 4','small-headline-aboutus4'), array('Headline 4','headline-aboutus4'), array('Text 4','text-aboutus4'));
    ?>
        <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_aboutuss as $meta_aboutus){ ?>
                <div>
                    <p><b><?php echo $meta_aboutus[0] ?></b></p>
                    <?php 
                        if ( isset ( $aboutus_stored_meta[$meta_aboutus[1]] ) ) {
                            $default_input = $aboutus_stored_meta[$meta_aboutus[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_aboutus[1] ?>" id="<?php echo $meta_aboutus[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
        </div>
    <?php
}

function aboutus_data_save( $post_id ) {

    $meta_aboutuss = array(array('Small headline 1','small-headline-aboutus1'), array('Headline 1','headline-aboutus1'), array('Text 1','text-aboutus1'), array('Small headline 2','small-headline-aboutus2'), array('Headline 2','headline-aboutus2'), array('Text 2','text-aboutus2'), array('Small headline 3','small-headline-aboutus3'), array('Headline 3','headline-aboutus3'), array('Text 3','text-aboutus3'), array('Small headline 4','small-headline-aboutus4'), array('Headline 4','headline-aboutus4'), array('Text 4','text-aboutus4'));

    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'aboutus_nonce' ] ) && wp_verify_nonce( $_POST[ 'aboutus_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    foreach($meta_aboutuss as $meta_aboutus){
        if( isset( $_POST[ $meta_aboutus[1] ] ) ) {
            update_post_meta( $post_id, $meta_aboutus[1], $_POST[ $meta_aboutus[1] ] );
        }
    }
 
}
add_action( 'save_post', 'aboutus_data_save' );


add_action( 'after_setup_theme', 'aboutus_photo_setup' );
function aboutus_photo_setup(){
    add_action( 'save_post', 'aboutus_photo_meta_box_save' );
}

function aboutus_photo_meta_box(){
    add_meta_box('aboutus_photo_meta_box',__( 'About Us - photos', 'yourdomain'),'aboutus_photo_meta_box_func','aboutus');
}

add_action( 'add_meta_boxes', 'aboutus_photo_meta_box' );

function aboutus_photo_meta_box_func($post){

    $meta_keys = array('aboutus_photo_1', 'aboutus_photo_2', 'aboutus_photo_3', 'aboutus_photo_4', 'aboutus_photo_5', 'aboutus_photo_6', 'aboutus_photo_7', 'aboutus_photo_8', 'aboutus_photo_9');
    ?>
    <div style="--grid-layout-gap: 10px; --grid-column-count: 6; --grid-item--min-width: 200px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
    <?php
    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
        <div class="aboutus_photo_wrapper" id="<?php echo $meta_key; ?>_wrapper">
            <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val)[0]:''); ?>" style="max-width:300px;width:100%;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt="">
            <a class="addimage button" style="margin-top:10px;margin-bottom:10px;" onclick="aboutus_photo_add_image('<?php echo $meta_key; ?>');"><?php _e('Add image','yourdomain'); ?></a><br>
            <a class="removeimage" style="padding-left:10px;color:#a00;cursor:pointer;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="aboutus_photo_remove_image('<?php echo $meta_key; ?>');"><?php _e('Delete image','yourdomain'); ?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php } ?>
    </div>
    <script>
    function aboutus_photo_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        aboutus_photo_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select photo','yourdomain'); ?>',
            button: {
                text: '<?php _e('Select photo','yourdomain'); ?>'
            },
            multiple: false
        });
        aboutus_photo_uploader.on('select', function() {

            var attachment = aboutus_photo_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        aboutus_photo_uploader.on('open', function(){
            var selection = aboutus_photo_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        aboutus_photo_uploader.open();
        return false;
    }

    function aboutus_photo_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
    wp_nonce_field( 'aboutus_photo_meta_box', 'aboutus_photo_meta_box_nonce' );
}

function aboutus_photo_meta_box_save($post_id){

    if ( ! current_user_can( 'edit_posts', $post_id ) ){ return 'not permitted'; }

    if (isset( $_POST['aboutus_photo_meta_box_nonce'] ) && wp_verify_nonce($_POST['aboutus_photo_meta_box_nonce'],'aboutus_photo_meta_box' )){

        $meta_keys = array('aboutus_photo_1', 'aboutus_photo_2', 'aboutus_photo_3', 'aboutus_photo_4', 'aboutus_photo_5', 'aboutus_photo_6', 'aboutus_photo_7', 'aboutus_photo_8', 'aboutus_photo_9');
        foreach($meta_keys as $meta_key){
            if(isset($_POST[$meta_key]) && intval($_POST[$meta_key])!=''){
                update_post_meta( $post_id, $meta_key, intval($_POST[$meta_key]));
            }else{
                update_post_meta( $post_id, $meta_key, '');
            }
        }
    }
}

// Custom post type - About Us


// Custom post type - Contact

function create_contact_post_type() {
 
    $labels = array(
        'name' => __( 'Contact' ),
        'singular_name' => __( 'Search' ),
        'all_items'           => __( 'All Pages' ),
        'view_item'           => __( 'Show Content' ),
        'add_new_item'        => __( 'Add New' ),
        'add_new'             => __( 'Add New' ),
        'edit_item'           => __( 'Edit' ),
        'update_item'         => __( 'Update' ),
        'search_items'        => __( 'Search' ),
        'search_items' => __('Search')
    );
   
    $args = array(
        'labels' => $labels,
        'description' => 'Add New Contact',
        'public' => true,
        'has_archive' => true,
        'map_meta_cap' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-admin-page',
        'rewrite' => array('slug' => false),
        'supports' => array(
            'title'
        ),
    );
    register_post_type( 'contact', $args);
   
}

add_action( 'init', 'create_contact_post_type' );
    
add_action( 'init', function() {
    remove_post_type_support( 'contact', 'slug' );
});


function custom_contact() {
    add_meta_box( 'contact_data', __( 'Contact', 'contact-textdomain' ), 'contact_data_callback', 'contact' );
}
add_action( 'add_meta_boxes', 'custom_contact' );

function contact_data_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'contact_nonce' );
    $contact_stored_meta = get_post_meta( $post->ID );
    $meta_contacts = array(array('Small headline','small-headline-contact'), array('Headline','headline-contact'), array('Text','text-contact'), array('Location','location-contact'), array('Working hour','working-hour-contact'), array('Working hour information','working-hour-info-contact'), array('Phone','phone-contact'), array('Mail for messages from contact form','mail-contact'), array('Facebook URL','facebook-contact'), array('Twitter URL','twitter-contact'), array('Instagram URL','instagram-contact'), array('LinkedIn URL','linkedin-contact'));
    ?>
        <div style="--grid-layout-gap: 10px; --grid-column-count: 2; --grid-item--min-width: 400px; --gap-count: calc(var(--grid-column-count) - 1); --total-gap-width: calc(var(--gap-count) * var(--grid-layout-gap)); --grid-item--max-width: calc((100% - var(--total-gap-width)) / var(--grid-column-count)); display: grid; grid-template-columns: repeat(auto-fill, minmax(max(var(--grid-item--min-width), var(--grid-item--max-width)), 1fr)); grid-gap: var(--grid-layout-gap);">
            <?php foreach($meta_contacts as $meta_contact){ ?>
                <div>
                    <p><b><?php echo $meta_contact[0] ?></b></p>
                    <?php 
                        if ( isset ( $contact_stored_meta[$meta_contact[1]] ) ) {
                            $default_input = $contact_stored_meta[$meta_contact[1]][0];
                        }
                    ?>
                    <input type="text" name="<?php echo $meta_contact[1] ?>" id="<?php echo $meta_contact[1] ?>" value="<?php echo esc_attr( $default_input ); ?>" style="width: 100%;" />
                </div>
            <?php } ?>
        </div>
    <?php
}

function contact_data_save( $post_id ) {

    $meta_contacts = array(array('Small headline','small-headline-contact'), array('Headline','headline-contact'), array('Text','text-contact'), array('Location','location-contact'), array('Working hour','working-hour-contact'), array('Working hour information','working-hour-info-contact'), array('Phone','phone-contact'), array('Mail','mail-contact'), array('Facebook URL','facebook-contact'), array('Twitter URL','twitter-contact'), array('Instagram URL','instagram-contact'), array('LinkedIn URL','linkedin-contact'));

    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'contact_nonce' ] ) && wp_verify_nonce( $_POST[ 'contact_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    foreach($meta_contacts as $meta_contact){
        if( isset( $_POST[ $meta_contact[1] ] ) ) {
            update_post_meta( $post_id, $meta_contact[1], $_POST[ $meta_contact[1] ] );
        }
    }
 
}
add_action( 'save_post', 'contact_data_save' );

// Custom post type - Contact


//Disable comments

add_action('admin_init', function () {
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

add_filter('comments_array', '__return_empty_array', 10, 2);

add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

//Disable comments

?>
