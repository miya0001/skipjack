<?php
/*
Plugin Name: Posts in Category
Description: 選択したカテゴリーの最新の記事を表示する。
Author: Takayuki Miyauchi (THETA NETWORKS Co,.Ltd)
Version: 0.1
Author URI: http://firegoby.theta.ne.jp/
*/

class PostsCatWidget extends WP_Widget {

    private $num = 5;

    function __construct() {
		$widget_ops = array('description' => '任意のカテゴリー内の投稿');
		$control_ops = array('width' => 400, 'height' => 350);
        parent::__construct(false, 'Posts in Category', $widget_ops, $control_ops);
    }

    public function form($instance) {
        // outputs the options form on admin
        $category = (isset($instance['category']) && intval($instance['category'])) ? $instance['category'] : '';
        $pfield = $this->get_field_id('category');
        $pfname = $this->get_field_name('category');
        $cats = get_categories();
        echo '<p>';
        echo "選択したカテゴリーの記事を表示します。<br />";
        echo "<select class=\"widefat\" id=\"{$pfield}\" name=\"{$pfname}\">";
        $op = '<option value="%s"%s>%s</option>';
        printf($op, '', '', '');
        foreach ($cats as $c) {
            if ($category === $c->term_id) {
                printf($op, $c->term_id, ' selected="selected"', $c->name);
            } else {
                printf($op, $c->term_id, '', $c->name);
            }
        }
        echo "</select>";
        echo '</p>';

        $sizes = get_intermediate_image_sizes();
        $size = (isset($instance['size']) && $instance['size']) ? $instance['size'] : '';
        $sfield = $this->get_field_id('size');
        $sfname = $this->get_field_name('size');
        echo '<p>';
        echo 'サムネールのサイズ:<br />';
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

        $nvalue = (isset($instance['num']) && intval($instance['num'])) ? $instance['num'] : $this->num;
        if ($nvalue === 0) {
            $nvalue = $this->num;
        }
        $nfield = $this->get_field_id('num');
        $nfname = $this->get_field_name('num');
        echo '<p>';
        echo '表示する投稿数:<br />';
        printf(
            '<input type="text" name="%s" id="%s" value="%s" size="3" />',
            $nfname,
            $nfield,
            $nvalue
        );
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
        if (isset($instance['category']) && intval($instance['category'])) {
            $cat = $instance['category'];
        } else {
            return;
        }
        $size = ($instance['size']) ?: '';
        $num  = (intval($instance['num'])) ?: $this->num;
        $catname = get_cat_name($cat);
        $tpl  = ($instance['tpl']) ? $instance['tpl'] : $this->template();

        $params = array(
            "post_type"      => "post",
            "posts_per_page" => $num,
            "cat"            => $cat,
            "post_status"    => 'publish',
            "orderby"        => 'date',
            "order"          => "DESC",
        );

        echo $args['before_widget'];
        echo $args['before_title'];
        echo $catname;
        echo $args['after_title'];
        echo '<div class="post-cat-widget">';

        $class = array(
            'category-'.$cat,
            'size-'.$size,
            'post'
        );
        if ($size) {
            $class[] = 'size-'.$size;
        }

        query_posts($params);
        if (have_posts()){
            $i = 0;
            while (have_posts()){
                the_post();
                $oe = ($i % 2) ? 'even' : 'odd';
                $post_id   = get_the_id();
                $post_date = get_the_time(get_option('date_format'));
                $post_url  = get_permalink();
                $post_title = get_the_title();
                $post_excerpt = get_the_excerpt();
                if ($size) {
                    $post_thumb = get_the_post_thumbnail($post_id, $size);
                } else {
                    $post_thumb = '';
                }
                $html = $tpl;
                $html = str_replace('%post_title%', esc_attr($post_title), $html);
                $html = str_replace('%post_date%', $post_date, $html);
                $html = str_replace('%post_url%', $post_url, $html);
                $html = str_replace('%post_thumb%', $post_thumb, $html);
                $html = str_replace('%post_excerpt%', esc_attr($post_excerpt), $html);
                $html = str_replace('%class%', join(' ', $class).' '.$oe, $html);
                echo $html;
                $i = $i + 1;
            }
        }
        wp_reset_query();

        echo '</div>';
        echo $args['after_widget'];
    }

    private function template()
    {
        $html = '<div class="%class%">';
        $html .= '<a href="%post_url%">%post_thumb%</a>';
        $html .= '<div class="post-content">';
        $html .= '<h3 class="post-title">';
        $html .= '<a href="%post_url%">%post_title%</a>';
        $html .= '</h3>';
        $html .= '<div class="post_date">%post_date%</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

add_action(
    'widgets_init',
    create_function('', 'return register_widget("PostsCatWidget");')
);

?>
