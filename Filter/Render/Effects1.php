<?php

namespace OXI_IMAGE_HOVER_UPLOADS\Display\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects1 extends Public_Render {

    public function public_jquery() {
        wp_enqueue_script('oxi_image_style-1-loader', OXI_IMAGE_HOVER_UPLOAD_URL . 'Display/Files/style-1-loader.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        $this->JSHANDLE = 'oxi_image_style-1-loader';
    }

    public function public_css() {
        wp_enqueue_style('oxi-image-hover-display-style-1', OXI_IMAGE_HOVER_UPLOAD_URL . '/Display/Files/style-1.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function default_render($style, $child, $admin) {
        
    }

}
