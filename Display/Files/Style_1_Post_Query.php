<?php

namespace OXI_IMAGE_HOVER_UPLOADS\Display\Files;

class Style_1_Post_Query {

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $wpdb;

    /**
     * Database Parent Table
     *
     * @since 9.3.0
     */
    public $parent_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $import_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $child_table;

    public function __construct($function = '', $rawdata = '', $args = '', $optional = '') {

        if (!empty($function) && !empty($rawdata)):
            global $wpdb;
            $this->wpdb = $wpdb;
            $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
            $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
            $this->$function($rawdata, $args, $optional);
        endif;
    }

    public function __ajax_template($style, $args, $optional) {
       $rawdata = '';
        if (!is_array($args)):
            $args = json_decode($args, TRUE);
        endif;
        $args ['offset'] = (int) $args['offset'] + (((int) $optional - 1) * (int) $args['posts_per_page']);
        if (!is_array($style)):
            $style = json_decode($style, TRUE);
        endif;
        echo $this->post_query($rawdata, $args, $style);
    }

    public function post_query($rawdata, $args, $style) {
        $styleid = $style['display_post_style'];
        $styledata = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $styleid), ARRAY_A);
        if(!is_array($styledata)):
            echo '<p> Style Data not found. Kindly Check Display Post <a href="https://www.image-hover.oxilab.org/docs/hover-extension/display-post/">Documentation</a>.</p>';
        endif;
        
        $child = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d", $styleid), ARRAY_A);
        $demo = json_decode(stripslashes($child['rawdata']), true);
        $query = new \WP_Query($args);
        $postdata = [];
        $i = 1;
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $postdata[$i] = $child;
                $rawdata = $demo;
                $query->the_post();
                if (has_post_thumbnail()):
                    $rawdata['image_hover_image-image'] = esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $style['display_post_thumb_sizes']));
                    $rawdata['image_hover_image-select'] = 'media-library';
                endif;
                $rawdata['image_hover_heading'] = get_the_title();
                $rawdata['image_hover_description'] = implode(" ", array_slice(explode(" ", strip_tags(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()))), 0, $style['display_post_excerpt'])).' ...';
                $rawdata['image_hover_button_link-url'] = get_the_permalink();
                $postdata[$i]['rawdata'] = json_encode($rawdata);
                $i++;
            }
        }else{
            return 'sdfghjklcns';
        }
        wp_reset_postdata();
        $StyleName = explode('-', ucfirst($styledata['style_name']));
        $cls = '\OXI_IMAGE_HOVER_UPLOADS\\' . $StyleName[0] . '\Render\Effects' . $StyleName[1];
        new $cls($styledata, $postdata, 'request');
    }

}
