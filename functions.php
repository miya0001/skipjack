<?php

define("SKIPJACK_VERSION", "1.3.3");

require_once(dirname(__FILE__).'/includes/add_meta_box.php');

define("SJ_EXCERPT_LENGTH", 120);

add_action('after_setup_theme', 'sj_setup');

if (! function_exists('sj_setup')):
function sj_setup() {
	load_theme_textdomain('skipjack', TEMPLATEPATH . '/languages');

    add_image_size('featured', 940, 360, true);
    add_image_size('270x152', 270, 152, true);
    set_post_thumbnail_size(638, 244, true);

    add_editor_style();
    add_theme_support('post-formats', array('aside', 'gallery'));
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');

    register_nav_menus(array(
        'primary' => __("Main Menu", "skipjack"),
    ));

    register_nav_menus(array(
        'secondly' => __("Header Menu", "skipjack"),
    ));

    add_custom_background();

    if (! defined('HEADER_TEXTCOLOR'))
        define('HEADER_TEXTCOLOR', '');

    define('HEADER_IMAGE_WIDTH', apply_filters('sj_header_image_width', 300));
    define('HEADER_IMAGE_HEIGHT', apply_filters('sj_header_image_height', 60));

    define('NO_HEADER_TEXT', true);

    add_custom_image_header('', 'sj_admin_header_style');
}
endif;

/*
    add support post format to page
*/
add_post_type_support('page', 'post-formats');
add_filter("body_class", "sj_body_class");
if (!function_exists('sj_body_class')):
function sj_body_class($classes) {
    if (is_page()) {
        global $post;
        $fmt = 'page-format-'.get_post_format($post->ID);
        $classes[] = $fmt;
    }
    return $classes;
}
endif;


if (!function_exists('sj_header_image')) :
function sj_header_image() {
    if ($img = get_header_image()) {
        printf('<img src="%s" alt="%s" />', $img, get_bloginfo('name'));
    } else {
        bloginfo('name');
    }
}
endif;

if (! function_exists('sj_admin_header_style')) :
function sj_admin_header_style() {
?>
<style type="text/css">
.appearance_page_custom-header #headimg {
    background-repeat: no-repeat;
    padding: 0;
    height: 60px;
    min-height: 60px;
}
</style>
<?php
}
endif;

add_action('init', 'sj_load_scripts');
if (!function_exists('sj_load_scripts')) :
function sj_load_scripts() {
    if ( !is_admin() ) {
        wp_deregister_script( 'jquery' );
        wp_register_script(
            'jquery',
            'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
            false,
            null,
            true
        );
        wp_register_script(
            'carousel',
            get_bloginfo('template_directory').'/js/carousel.js',
            array('jquery'),
            SKIPJACK_VERSION,
            true
        );
        wp_register_script(
            'skipjack',
            get_bloginfo('template_directory').'/js/sj.js',
            array('jquery', 'carousel'),
            SKIPJACK_VERSION,
            true
        );
        wp_enqueue_script('skipjack');
    }
}
endif;

if (!function_exists('sj_featured_slide')) :
function sj_featured_slide() {
    $args = array(
        "post_type"         => "any",
        "nopaging"          => 0,
        "posts_per_page"    => 20,
        "post_status"       => 'publish',
        "meta_key"          => '_featured',
        "orderby"           => 'meta_value_num',
        "order"             => 'DESC',
    );
    query_posts($args);
    if (!have_posts()) {
        wp_reset_query();
        $args = array(
            "post_type"         => "any",
            "nopaging"          => 0,
            "posts_per_page"    => 20,
            "post_status"       => 'publish',
            "orderby"           => 'modified',
            "order"             => 'DESC',
        );
        query_posts($args);
    }
    while (have_posts()) {
        the_post();
        global $post;
        $url    = get_permalink();
        if ($tid = get_post_thumbnail_id()) {
            $src = wp_get_attachment_image_src($tid, 'featured');
            $image = $src[0];
        } else {
            $image = get_bloginfo('stylesheet_directory').'/img/default.jpg';
        }
        $title  = get_the_title();
        $exc    = get_the_excerpt();
        echo '<div class="slide">';
        printf(
            '<div class="wrap" style="background-image:url(%s);" onclick="%s">',
            $image,
            "location.href='".$url."';"
        );
        echo '<div class="meta">';
        echo '<h2><a href="'.$url.'">'.$title.'</a></h2>';
        echo '<div class="excerpt">'.$exc.'</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    wp_reset_query();
}
endif;

if (! function_exists('sj_comment')) :
function sj_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type) :
        case '' :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>">
        <div class="comment-author vcard">
            <?php echo get_avatar($comment, 40); ?>
            <?php printf(__('%s <span class="says">says:</span>', 'skipjack'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
        </div><!-- .comment-author .vcard -->
        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'skipjack'); ?></em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
            <?php
                /* translators: 1: date, 2: time */
                printf(__('%1$s at %2$s', 'skipjack'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(__('(Edit)', 'skipjack'), ' ');
            ?>
        </div><!-- .comment-meta .commentmetadata -->

        <div class="comment-body"><?php comment_text(); ?></div>

        <div class="reply">
            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
        </div><!-- .reply -->
    </div><!-- #comment-##  -->

    <?php
            break;
        case 'pingback'  :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e('Pingback:', 'skipjack'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'skipjack'), ' '); ?></p>
    <?php
            break;
    endswitch;
}
endif;

if (!function_exists("sj_widgets_init")) :
function sj_widgets_init() {
    register_sidebar(array(
        'name' => __('Home (1)', "skipjack"),
        'id' => 'first-home-widget-area',
        'description' => __('The first home widget area', 'skipjack'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Home (2)', "skipjack"),
        'id' => 'second-home-widget-area',
        'description' => __('The second home widget area', 'skipjack'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Home (3)', "skipjack"),
        'id' => 'third-home-widget-area',
        'description' => __('The third home widget area', 'skipjack'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Pages (1)', "skipjack"),
        'id' => 'primary-page-widget-area',
        'description' => __('The primary widget area for Page', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Pages (2)', "skipjack"),
        'id' => 'secondary-page-widget-area',
        'description' => __('The secondary widget area for Page', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Posts (1)', "skipjack"),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area for Post', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Posts (2)', "skipjack"),
        'id' => 'secondary-widget-area',
        'description' => __('The secondary widget area for Post', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('footer (1)', "skipjack"),
        'id' => 'first-footer-widget-area',
        'description' => __('The first footer widget area', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('footer (2)', "skipjack"),
        'id' => 'second-footer-widget-area',
        'description' => __('The second footer widget area', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('footer (3)', "skipjack"),
        'id' => 'third-footer-widget-area',
        'description' => __('The third footer widget area', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('footer (4)', "skipjack"),
        'id' => 'fourth-footer-widget-area',
        'description' => __('The fourth footer widget area', 'skipjack'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
endif;
add_action('widgets_init', 'sj_widgets_init');

function sj_remove_recent_comments_style() {
    add_filter('show_recent_comments_widget_style', '__return_false');
}
add_action('widgets_init', 'sj_remove_recent_comments_style');

if (! function_exists('sj_posted_in')) :
function sj_posted_in() {
    $tag = '<div class="%s">%s</div>';
    echo '<div class="post-meta">';
    the_date();
    echo ' by ';
    the_author_posts_link();
    echo '</div>';

    $cat = get_the_category_list(', ');
    if ($cat) {
        printf($tag, 'post-meta', __('Category').': '.$cat);
    }
}
endif;

if (!function_exists("sj_breadcrumb")):
function sj_breadcrumb() {
    global $post;
    $sep = '&nbsp;&raquo;&nbsp;';
    printf(
        '<a href="'.get_option('home').'" title="%1$s">%1$s</a>%2$s',
        __('Home', 'skipjack'),
        $sep
    );

    $ancestors = get_post_ancestors($post->ID);
	$ancestors = array_reverse($ancestors);
    foreach ($ancestors as $parid) {
        $title = get_page($parid)->post_title;
        printf(
            '<a href="%1$s" title="%2$s">%2$s</a>%3$s',
            get_page_link($parid),
            $title,
            $sep
        );
    }
    the_title();
}
endif;

function sj_get_the_excerpt($str) {
    if (mb_strlen($str) > SJ_EXCERPT_LENGTH) {
        return mb_substr($str, 0, SJ_EXCERPT_LENGTH).'...';
    } else {
        return mb_substr($str, 0, SJ_EXCERPT_LENGTH);
    }
}
add_filter('get_the_excerpt', 'sj_get_the_excerpt');

function sj_search_form( $form ) {
    return preg_replace("/<label.+?<\/label>/", "", $form);
}
add_filter('get_search_form', 'sj_search_form');

?>
