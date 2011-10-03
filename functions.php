<?php

require_once(dirname(__FILE__).'/widgets/posts-widget.php');
require_once(dirname(__FILE__).'/widgets/singlepost-widget.php');
require_once(dirname(__FILE__).'/includes/add_meta_box.php');
require_once(dirname(__FILE__).'/shortcodes/list_subpages.php');
require_once(dirname(__FILE__).'/shortcodes/internal-links.php');

define("SJ_EXCERPT_LENGTH", 120);

add_action('after_setup_theme', 'sj_setup');

if (! function_exists('sj_setup')):
function sj_setup() {
    add_image_size('featured', 940, 360, true);
    add_image_size('list_subpages', 270, 152, true);
    set_post_thumbnail_size(638, 244, true);

    add_editor_style();
    add_theme_support('post-formats', array('aside', 'gallery'));
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');

    register_nav_menus(array(
        'primary' => "メインメニュー",
    ));

    register_nav_menus(array(
        'secondly' => "ヘッダーメニュー",
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
            null,
            true
        );
        wp_register_script(
            'sj',
            get_bloginfo('template_directory').'/js/sj.js',
            array('jquery', 'carousel'),
            null,
            true
        );
        wp_enqueue_script('sj');
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

    $par = array();
    foreach ($args as $key => $value) {
        $par[] = $key.'='.$value;
    }
    query_posts(join('&', $par));
    $data = array();
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            global $post;
            $url    = get_permalink();
            $tid    = get_post_thumbnail_id();
            $img    = wp_get_attachment_image_src($tid, 'featured');
            $title  = get_the_title();
            $exc    = get_the_excerpt();
            echo '<div class="slide">';
            printf(
                '<div class="wrap" style="background-image:url(%s);" onclick="%s">',
                $img[0],
                "location.href='".$url."';"
            );
            echo '<div class="meta">';
            echo '<h2><a href="'.$url.'">'.$title.'</a></h2>';
            echo '<div class="excerpt">'.$exc.'</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
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
            <?php printf(__('%s <span class="says">says:</span>', 'sj'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
        </div><!-- .comment-author .vcard -->
        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'sj'); ?></em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
            <?php
                /* translators: 1: date, 2: time */
                printf(__('%1$s at %2$s', 'sj'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(__('(Edit)', 'sj'), ' ');
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
        <p><?php _e('Pingback:', 'sj'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'sj'), ' '); ?></p>
    <?php
            break;
    endswitch;
}
endif;

if (!function_exists("sj_widgets_init")) :
function sj_widgets_init() {
    register_sidebar(array(
        'name' => 'ホームページ（１）',
        'id' => 'first-home-widget-area',
        'description' => __('The first home widget area', 'sj'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'ホームページ（２）',
        'id' => 'second-home-widget-area',
        'description' => __('The second home widget area', 'sj'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'ホームページ（３）',
        'id' => 'third-home-widget-area',
        'description' => __('The third home widget area', 'sj'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => '固定ページサイドバー（１）',
        'id' => 'primary-page-widget-area',
        'description' => __('The primary widget area', 'sj'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => '固定ページサイドバー（２）',
        'id' => 'secondary-page-widget-area',
        'description' => __('The secondary widget area', 'sj'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => '投稿サイドバー（１）',
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', 'sj'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => '投稿サイドバー（２）',
        'id' => 'secondary-widget-area',
        'description' => __('The secondary widget area', 'sj'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'フッター（１）',
        'id' => 'first-footer-widget-area',
        'description' => __('The first footer widget area', 'sj'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'フッター（２）',
        'id' => 'second-footer-widget-area',
        'description' => __('The second footer widget area', 'sj'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'フッター（３）',
        'id' => 'third-footer-widget-area',
        'description' => __('The third footer widget area', 'sj'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'フッター（４）',
        'id' => 'fourth-footer-widget-area',
        'description' => __('The fourth footer widget area', 'sj'),
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
    echo '<div class="post_meta">';
    the_date();
    echo ' by ';
    the_author_posts_link();
    echo '</div>';

    $cat = get_the_category_list(', ');
    if ($cat) {
        printf($tag, 'post_meta', 'カテゴリー: '.$cat);
    }

    $tag_list = get_the_tag_list('', ', ');
    if ($tag_list) {
        printf($tag, 'post_meta last', 'タグ: '.$tag_list);
    }
}
endif;

if (!function_exists('social_button')):
function social_button(){
?>
<div id="social">
<!--twitter-->
<div class="btn tweet">
<a href="http://twitter.com/share?url=<?php echo urlencode(get_permalink()); ?>" class="twitter-share-button" data-count="horizontal" data-lang="ja">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</div>
<!--hatena-->
<div class="btn hatena">
<a href="http://b.hatena.ne.jp/entry/<?php the_permalink(); ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?php the_title(); ?>" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
</div>
<!--facebook-->
<div class="btn facebook">
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=button_count&amp;width=110&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe>
</div>
<!--plusone-->
<div class="btn plusone">
<g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: 'ja'}</script>
</div>
</div><!--end #social-->
<?php
}
endif;

if (!function_exists("sj_breadcrumb")):
function sj_breadcrumb() {
    global $post;
    $sep = '&nbsp;&raquo;&nbsp;';
    printf(
        '<a href="'.get_option('home').'" title="%1$s">%1$s</a>%2$s',
        'ホーム',
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


add_filter('wp_handle_upload', 'my_resize_image');
function my_resize_image($file) {
    $w = intval(1280);
    $h = intval(1280);
    $new = image_resize($file['file'], $w, $h);
    if (is_file($new)) {
      rename($new, $file['file']);
    }
    return $file;
}

