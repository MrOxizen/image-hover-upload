<?php

namespace OXI_IMAGE_HOVER_UPLOADS\Carousel\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;
use OXI_IMAGE_HOVER_UPLOADS\Display\Files\Style_1_Post_Query as Post_Query;

class Effects1 extends Public_Render {

    public function public_jquery() {
        wp_enqueue_script('oxi-image-carousel-slick.min', OXI_IMAGE_HOVER_UPLOAD_URL . 'Carousel/Files/slick.min.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        $this->JSHANDLE = 'oxi-image-carousel-slick.min';
    }

    public function public_css() {
        wp_enqueue_style('oxi-image-hover-carousel-slick', OXI_IMAGE_HOVER_UPLOAD_URL . '/Carousel/Files/slick.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function render() {
        echo '<div class="oxi-addons-container ' . $this->WRAPPER . ' oxi-image-hover-wrapper-' . (array_key_exists('carousel_register_style', $this->style) ? $this->style['carousel_register_style'] : '') . '">
                 <div class="oxi-addons-row">';
        $this->default_render($this->style, $this->child, $this->admin);
        echo '   </div>
              </div>';
    }

    public function public_column_render($col) {
        $column = 1;
        if (count(explode('-lg-', $col)) == 2):
            $column = explode('-lg-', $col)[1];
        elseif (count(explode('-md-', $col)) == 2):
            $column = explode('-md-', $col)[1];
        elseif (count(explode('-sm-', $col)) == 2):
            $column = explode('-sm-', $col)[1];
        endif;
        if($column == 12):
            return 1;
        elseif($column == 6):
            return 2;
        elseif($column == 4):
            return 3;
        elseif($column == 3):
            return 4;
        elseif($column == 2):
            return 6;
        else:
            return 12;    
        endif;
    }

    public function default_render($style, $child, $admin) {
        if (!array_key_exists('carousel_register_style', $style)):
            echo '<p>Kindly Select Image Effects Frist to Extend Carousel.</p>';
            return;
        endif;
        $styledata = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $style['carousel_register_style']), ARRAY_A);

        if (!is_array($styledata)):
            echo '<p> Style Data not found. Kindly Check CArousel & Slider <a href="https://www.image-hover.oxilab.org/docs/hover-extension/display-post/">Documentation</a>.</p>';
        endif;
        $files = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d", $style['carousel_register_style']), ARRAY_A);
        $StyleName = explode('-', ucfirst($styledata['style_name']));
        $cls = '\OXI_IMAGE_HOVER_UPLOADS\\' . $StyleName[0] . '\Render\Effects' . $StyleName[1];
        new $cls($styledata, $files, 'request');


        $col = json_decode(stripslashes($styledata['rawdata']), true);
        $lap = $this->public_column_render($col['oxi-image-hover-col-lap']);
        $tab = $this->public_column_render($col['oxi-image-hover-col-tab']);
        $mobile = $this->public_column_render($col['oxi-image-hover-col-mob']);

        $jquery = '(function ($) {$(".' . $this->WRAPPER . ' .oxi-addons-row").slick({
                                     slidesToShow: '.$lap.',
                                     responsive: [
                                                {
                                                  breakpoint: 991,
                                                  settings: {
                                                    slidesToShow:  '.$tab.',
                                                    slidesToScroll:  '.$tab.'
                                                  }
                                                },
                                                {
                                                  breakpoint: 768,
                                                  settings: {
                                                    slidesToShow:  '.$mobile.',
                                                    slidesToScroll:  '.$mobile.'
                                                  }
                                                }
                                              
                                              ]
                    });})(jQuery);';
        wp_add_inline_script($this->JSHANDLE, $jquery);
    }

}
