<?php
/*
Plugin Name: Single Post Widget
Description: 選択したカテゴリーの最新の記事を表示する。
Author: Takayuki Miyauchi (THETA NETWORKS Co,.Ltd)
Version: 0.1
Author URI: http://firegoby.theta.ne.jp/
*/

class SinglePostWidget extends WP_Widget {

    private $num = 5;

    function __construct() {
		$widget_ops = array('description' => '任意のカテゴリー内の投稿');
		$control_ops = array('width' => 400, 'height' => 350);
        parent::__construct(false, 'Single Post', $widget_ops, $control_ops);
    }

    public function form($instance) {
        // outputs the options form on admin
        $postid = (isset($instance['postid'])) ? $instance['postid'] : '';
        $pid = $this->get_field_id('postid');
        $pf = $this->get_field_name('postid');
        echo '<p>';
        echo "投稿のIDもしくはURLを入力してください。<br />";
        echo "<input type=\"text\" class=\"widefat\" id=\"{$pid}\" name=\"{$pf}\" value=\"{$postid}\" />";
        echo '</p>';

        $sizes = get_intermediate_image_sizes();
        $size = (isset($instance['size']) && $instance['size']) ? $instance['size'] : '';
        $sfield = $this->get_field_id('size');
        $sfname = $this->get_field_name('size');
        echo '<p>';
        echo 'サムネールのサイズ:<br />';
        $op = '<option value="%s"%s>%s</option>';
        echo "<select class=\"widefat\" id=\"{$sfield}\" name=\"{$sfname}\">";
        printf($op, '', '', '');
        foreach ($sizes as $s) {
            if ($s === $size) {
                printf($op, $s, ' selected="selected"', $s);
            } else {
                printf($op, $s, '', $s);
            }
        }
        echo "</select>";
        echo '</p>';

        $tpl_value = (isset($instance['tpl']) && $instance['tpl']) ? $instance['tpl'] : $this->template();
        $tpl_field = $this->get_field_id('tpl');
        $tpl_fname = $this->get_field_name('tpl');
        echo '<label for="'.$tpl_field.'">テンプレート:</label><br />';
        printf(
            '<textarea class="widefat" rows="16" cols="20" id="%s" name="%s">%s</textarea>',
            $tpl_field,
            $tpl_fname,
            htmlentities($tpl_value, ENT_QUOTES, 'UTF-8')
        );
    }

    public function update($new_instance, $old_instance) {
        // processes widget options to be saved
        return $new_instance;
    }

    public function widget($args, $instance) {
        $pid = null;
        if (isset($instance['postid']) && preg_match("/^[0-9]+$/", $instance['postid'])) {
            $pid = $instance['postid'];
        } elseif (isset($instance['postid']) && $instance['postid']) {
            $pid = url_to_postid($instance['postid']);
        }
        if (!$pid) {
            return '';
        }
        $tpl  = ($instance['tpl']) ? $instance['tpl'] : $this->template();
        if (!isset($instance['size'])) {
            $instance['size'] = '';
        }
        $p    = get_post($pid);
        $p->post_excerpt = $this->excerpt($p);

        echo $args['before_widget'];
        echo $args['before_title'];
        echo $p->post_title;
        echo $args['after_title'];

        $class = array(
            $p->post_type.'-'.$pid,
            $p->post_type,
            'single-post-widget'
        );
        if ($instance['size']) {
            $class[] = 'size-'.$instance['size'];
        }
        foreach ($p as $key => $value) {
            $tpl = str_replace('%'.$key.'%', $value, $tpl);
        }
        if ($instance['size']) {
            $post_thumb = get_the_post_thumbnail($pid, $instance['size']);
        } else {
            $post_thumb = '';
        }
        $tpl = str_replace('%post_thumb%', $post_thumb, $tpl);
        $tpl = str_replace('%post_permalink%', get_permalink($pid), $tpl);
        $tpl = str_replace('%class%', join(' ', $class), $tpl);
        echo $tpl;
        echo $args['after_widget'];
    }

    private function excerpt($post) {
        $exc = '';
        if ($post->post_excerpt) {
            $exc = $post->post_excerpt;
        } else {
            $exc = strip_tags($post->post_content);
        }
        if (mb_strlen($exc) > 120) {
            return mb_substr($exc, 0, 120).'...';
        } else {
            return $exc;
        }
    }

    private function template()
    {
        $html = '<div class="%class%">';
        $html .= '<div class="post_thumb"><a href="%post_permalink%">%post_thumb%</a></div>';
        $html .= '<div class="post_excerpt">%post_excerpt% <a href="%post_permalink%">&raquo; 続きを読む</a></div>';
        $html .= '</div>';
        return $html;
    }
}

add_action(
    'widgets_init',
    create_function('', 'return register_widget("SinglePostWidget");')
);

?>
