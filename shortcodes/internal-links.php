<?php
/*
Plugin Name: Internal Links
Author: Takayuki Miyauchi
*/

new internalLinks();

class internalLinks {

function __construct()
{
    wp_embed_register_handler(
        'internal_link',
        '#^('.get_bloginfo('url').'/.+)$#i',
        array(&$this, 'handler')
    );
    add_shortcode('internal_link', array(&$this, 'display'));
}

public function handler($matches, $attr, $url, $rawattr)
{
    $args = preg_split("/#/", $matches[1]);
    return "[internal_link url=\"{$args[0]}\" size=\"{$args[1]}\"]";
}

public function display($p){
    if (!isset($p['url']) || !$p['url']) {
        return ;
    }
    $id = url_to_postid($p['url']);
    if (isset($p['size']) && $p['size']) {
        $size = $p['size'];
    } else {
        $size = 'post-thumbnail';
    }
    $img = get_the_post_thumbnail($id, $size);
    $post = get_post($id);

    $html = '<div class="sc_post '.$size.'">';
    $html .= '<div class="post_thumb"><a href="'.$p['url'].'">'.$img.'</a></div>';
    $html .= '<div class="post_content">';
    $html .= '<h4>'.esc_attr($post->post_title).'</h4>';
    $html .= '<div class="post_excerpt">'.esc_attr($post->post_excerpt).'</div>';
    $html .= '<div class="more"><a href="'.$p['url'].'">続きを読む</a></div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

}

?>
