<?php

new add_featured_meta_box();

class add_featured_meta_box {

function __construct()
{
    add_action("admin_head-post.php", array(&$this, "add_meta_box"));
    add_action("admin_head-post-new.php", array(&$this, "add_meta_box"));
    add_action("save_post", array(&$this, "save_post_meta"));
}

public function add_meta_box()
{
    $post_type = get_post_type();
    if ($post_type == 'page' || $post_type == 'post') {
        add_meta_box(
            'featured_setting',
            'スライド表示',
            array(&$this, 'callback'),
            $post_type,
            'side',
            'low'
        );
    }
}

public function callback($post)
{
    $featured = get_post_meta($post->ID, '_featured', true);
    $nonce = wp_create_nonce(__FILE__);
    printf(
        '<input type="hidden" name="featured_nonce" value="%s" />',
        $nonce
    );
    echo '<div>';
    if (strlen($featured)) {
        echo '<input type="checkbox" value="1" name="featured" id="featured" checked="checked" />';
    } else {
        echo '<input type="checkbox" value="1" name="featured" id="featured" />';
        $featured = '0';
    }
    echo ' <label for="featured">この記事をスライドに表示</label>';
    echo '</div>';
    echo '<div id="featured-order-container" style="margin-top:1em;">';
    echo '<label for="">表示順</label>: ';
    printf(
        '<input type="text" id="%1$s" name="%1$s" value="%2$s" style="%3$s" />',
        'featured_order',
        $featured,
        "width:3em;"
    );
    echo '</div>';
    echo '<script type="text/javascript">';
    echo $this->admin_script();
    echo '</script>';
}

public function save_post_meta($id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $id;
    }

    if (isset($_POST['action']) && $_POST['action'] == 'inline-save') {
        return $id;
    }

    if (!isset($_POST['featured_nonce'])) {
        return $id;
    }

    if (!wp_verify_nonce($_POST['featured_nonce'], __FILE__)) {
        return $id;
    }

    if (isset($_POST['featured']) && $_POST['featured']) {
        update_post_meta($id, '_featured', intval($_POST['featured_order']));
    } else {
        delete_post_meta($id, '_featured');
    }

    return $id;
}

private function admin_script()
{
    $js =<<<EOL
(function(){
    if (!jQuery('#featured').prop("checked")) {
        jQuery('#featured-order-container').hide();
    }
    jQuery('#featured').click(function(){
        var bool = jQuery('#featured').prop("checked");
        if (bool) {
            jQuery('#featured-order-container').slideDown(100);
        } else {
            jQuery('#featured-order-container').slideUp(100);
        }
    });
})();
EOL;
    return $js;
}


}

?>
