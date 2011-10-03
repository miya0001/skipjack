<?php
/*
Plugin Name: List Subpages
Author: Takayuki Miyauchi
*/

new listSubpages();

class listSubpages {

function __construct()
{
    add_shortcode('list_subpages', array(&$this, 'shortcode'));
}

public function shortcode($p)
{
    if (!isset($p['thumbnail']) || !$p['thumbnail']) {
        $p['thumbnail'] = 'list_subpages';
    }
    return $this->blockView($p);
}

private function blockView($p)
{
    $posts = $this->get_posts($p);
    $size = $p['thumbnail'];
    $html = '<div class="list_subpages '.$size.'">';
    foreach ($posts as $post):
    $img = get_the_post_thumbnail($post->ID, $size);
    $url = get_permalink($post->ID);
    $html .= '<div class="post post-'.$post->ID.'">';
    $html .= '<div class="post_thumb"><a href="'.$url.'">'.$img.'</a></div>';
    $html .= '<div class="post_content">';
    $html .= '<h4><a href="'.$url.'">'.esc_attr($post->post_title).'</a></h4>';
    $html .= '<div class="post_excerpt">'.esc_attr($post->post_excerpt).'</div>';
    $html .= '</div>';
    $html .= '</div>';
    endforeach;
    $html .= '</div>';

    return $html;
}

private function get_posts($p)
{
	global $post;
	if( !isset($p['id']) || !strlen($p['id']) ){
		$p['id'] = $post->ID;
	}
    $args = array(
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_parent' => $p['id'],
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'numberposts' => '-1',
    ); 

    return get_posts($args);
}

}
?>
