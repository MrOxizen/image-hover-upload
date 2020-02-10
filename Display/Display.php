<?php

namespace OXI_IMAGE_HOVER_UPLOADS\Display;

/**
 * Description of General
 *
 * @author biplo
 */
use OXI_IMAGE_HOVER_PLUGINS\Page\Create as Create;

class Display extends Create {

    public function Admin_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Display Post › Create New</h1>
                <p> Select Image Hover layouts, Gives your Image Hover name and create new Image Hover.</p>
            </div>
        </div>
        <?php
    }

    public function Import_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Display Post › Import Templates</h1>
                <p> Select Image Hover layouts, Import Templates for future Use.</p>
            </div>
        </div>
        <?php
    }

    public function create_new() {
        echo __('<div class="modal fade" id="oxi-addons-style-create-modal" >
                        <form method="post" id="oxi-addons-style-modal-form">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">                    
                                        <h4 class="modal-title">New Display Post</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class=" form-group row">
                                            <label for="addons-style-name" class="col-sm-6 col-form-label" oxi-addons-tooltip="Give your Shortcode Name Here">Name</label>
                                            <div class="col-sm-6 addons-dtm-laptop-lock">
                                                <input class="form-control" type="text" value="" id="style-name"  name="style-name">
                                            </div>
                                        </div>
                                        <div class="form-group row d-none">
                                            <label for="oxi-tabs-link" class="col-sm-5 col-form-label" title="Select Layouts">Layouts</label>
                                            <div class="col-sm-7">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-secondary active">
                                                        <input type="radio" name="image-hover-box-layouts"value="1"  checked="">1st
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="oxistyledata" name="oxistyledata" value="">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-success" name="addonsdatasubmit" id="addonsdatasubmit" value="Save">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>');
    }

    public function template() {
        ?>
        <div class="oxi-addons-row">
            <?php
            $importbutton = false;
            foreach ($this->TEMPLATE as $key => $value) {
                $id = explode('-', $key)[1];
                if (array_key_exists($key, $this->activated_template)):
                    ?>
                    <div class="oxi-addons-col-1" id="<?php echo $key; ?>">
                        <div class="oxi-addons-style-preview">
                            <div class="oxi-addons-style-preview-top oxi-addons-center">
                                <?php
                                $i = 1;
                                foreach ($value['files'] as $v) {
                                    $style = json_decode($v, true);
                                    $s = explode('-', $style['style']['style_name']);
                                    echo '<div class="oxi-bt-col-lg-12 oxi-bt-col-md-12 oxi-bt-col-sm-12">';
                                    $CLASS = 'OXI_IMAGE_HOVER_UPLOADS\\' . ucfirst($s[0]) . '\Render\Effects' . $s[1];
                                    if (class_exists($CLASS)):
                                        new $CLASS($style['style'], $style['child']);
                                    endif;
                                    echo '<textarea style="display:none" id="oxistyle' . $id . 'data-' . $i . '">' . htmlentities(json_encode($style)) . '</textarea>';
                                    echo '</div>';
                                    $i++;
                                }
                                ?>
                            </div>
                            <div class="oxi-addons-style-preview-bottom">
                                <div class="oxi-addons-style-preview-bottom-left">
                                    
                                </div>
                                <div class="oxi-addons-style-preview-bottom-right">
                                    <button class="btn btn-warning oxi-addons-addons-style-btn-warning" title="Delete" data-value="<?php echo $id; ?>" data-effects="<?php echo $this->effects; ?>" type="button" value="Deactive" name="styledelete<?php echo $id; ?>">Deactive</button>  
                                    <button type="button" class="btn btn-success oxi-addons-addons-template-create" effects-data="oxistyle<?php echo $id; ?>data">Create Post Extension</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                else:
                    $importbutton = true;
                endif;
            }

            if ($importbutton):
                ?>
                <div class="oxi-addons-col-1 oxi-import">
                    <div class="oxi-addons-style-preview">
                        <div class="oxilab-admin-style-preview-top">
                            <a href="<?php echo admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$this->effects&import=templates"); ?>">
                                <div class="oxilab-admin-add-new-item">
                                    <span>
                                        <i class="fas fa-plus-circle oxi-icons"></i>  
                                        Add More Templates
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            ?>


        </div>
        <?php
    }

    public function import_template() {
        ?>
        <div class="oxi-addons-row">
            <?php
            foreach ($this->TEMPLATE as $key => $value) {
                $id = explode('-', $key)[1];
                if (!array_key_exists($key, $this->activated_template)):
                    ?>
                    <div class="oxi-addons-col-1" id="<?php echo $key; ?>">
                        <div class="oxi-addons-style-preview">
                            <div class="oxi-addons-style-preview-top oxi-addons-center">
                                <?php
                                $i = 1;
                                foreach ($value['files'] as $v) {
                                    $style = json_decode($v, true);
                                    $s = explode('-', $style['style']['style_name']);
                                    echo '<div class="oxi-bt-col-lg-12 oxi-bt-col-md-12 oxi-bt-col-sm-12">';
                                    $CLASS = 'OXI_IMAGE_HOVER_UPLOADS\\' . ucfirst($s[0]) . '\Render\Effects' . $s[1];
                                    if (class_exists($CLASS)):
                                        new $CLASS($style['style'], $style['child']);
                                    endif;
                                    echo '</div>';
                                    $i++;
                                }
                                ?>
                            </div>
                            <div class="oxi-addons-style-preview-bottom">
                                <div class="oxi-addons-style-preview-bottom-left">
                                 
                                </div>
                                <div class="oxi-addons-style-preview-bottom-right">
                                    <?php
                                    if (apply_filters('oxi-image-hover-plugin-version', false) == true):
                                        ?>
                                        <button class="btn btn-success oxi-addons-addons-style-btn-active" title="Active Templates" data-value="<?php echo $id; ?>" data-effects="<?php echo $this->effects; ?>" type="button" value="Active" name="styleactive<?php echo $id; ?>">Active Templates</button>  
                                        <?php
                                    else:
                                        ?>
                                        <button class="btn btn-danger" title="Premium Templates"  type="button" value="Premium Templates" name="styleactive<?php echo $id; ?>">Premium Templates</button>  
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
            }
            ?>
        </div>
        <?php
    }

    public function JSON_DATA() {
        $this->TEMPLATE = [
            'display-1' => [
                'name' => 'Display Post <span>General, Square & Caption effects Extension</span>',
                'files' => [
                    '{"plugin":"image-hover","style":{"id":"16","type":"","name":"Comparison 01 demo 01","style_name":"display-1","rawdata":"{\"oxi_image_magnifier_column-lap\":\"oxi-bt-col-lg-12\",\"oxi_image_magnifier_column-tab\":\"oxi-bt-col-md-12\",\"oxi_image_magnifier_column-mob\":\"oxi-bt-col-sm-12\",\"oxi_image_magnifier_button_border-type\":\"\",\"oxi_image_magnifier_button_border-width-lap-choices\":\"px\",\"oxi_image_magnifier_button_border-width-lap-top\":\"\",\"oxi_image_magnifier_button_border-width-lap-right\":\"\",\"oxi_image_magnifier_button_border-width-lap-bottom\":\"\",\"oxi_image_magnifier_button_border-width-lap-left\":\"\",\"oxi_image_magnifier_button_border-width-tab-choices\":\"px\",\"oxi_image_magnifier_button_border-width-tab-top\":\"\",\"oxi_image_magnifier_button_border-width-tab-right\":\"\",\"oxi_image_magnifier_button_border-width-tab-bottom\":\"\",\"oxi_image_magnifier_button_border-width-tab-left\":\"\",\"oxi_image_magnifier_button_border-width-mob-choices\":\"px\",\"oxi_image_magnifier_button_border-width-mob-top\":\"\",\"oxi_image_magnifier_button_border-width-mob-right\":\"\",\"oxi_image_magnifier_button_border-width-mob-bottom\":\"\",\"oxi_image_magnifier_button_border-width-mob-left\":\"\",\"oxi_image_magnifier_button_border-color\":\"\",\"oxi_image_magnifier_radius-lap-choices\":\"px\",\"oxi_image_magnifier_radius-lap-top\":\"\",\"oxi_image_magnifier_radius-lap-right\":\"\",\"oxi_image_magnifier_radius-lap-bottom\":\"\",\"oxi_image_magnifier_radius-lap-left\":\"\",\"oxi_image_magnifier_radius-tab-choices\":\"px\",\"oxi_image_magnifier_radius-tab-top\":\"\",\"oxi_image_magnifier_radius-tab-right\":\"\",\"oxi_image_magnifier_radius-tab-bottom\":\"\",\"oxi_image_magnifier_radius-tab-left\":\"\",\"oxi_image_magnifier_radius-mob-choices\":\"px\",\"oxi_image_magnifier_radius-mob-top\":\"\",\"oxi_image_magnifier_radius-mob-right\":\"\",\"oxi_image_magnifier_radius-mob-bottom\":\"\",\"oxi_image_magnifier_radius-mob-left\":\"\",\"oxi_image_magnifier_shadow-shadow\":\"yes\",\"oxi_image_magnifier_shadow-type\":\"\",\"oxi_image_magnifier_shadow-horizontal-size\":\"0\",\"oxi_image_magnifier_shadow-vertical-size\":\"0\",\"oxi_image_magnifier_shadow-blur-size\":\"0\",\"oxi_image_magnifier_shadow-spread-size\":\"0\",\"oxi_image_magnifier_shadow-color\":\"#cccccc\",\"oxi_image_magnifier_padding-lap-choices\":\"px\",\"oxi_image_magnifier_padding-lap-top\":\"\",\"oxi_image_magnifier_padding-lap-right\":\"\",\"oxi_image_magnifier_padding-lap-bottom\":\"\",\"oxi_image_magnifier_padding-lap-left\":\"\",\"oxi_image_magnifier_padding-tab-choices\":\"px\",\"oxi_image_magnifier_padding-tab-top\":\"\",\"oxi_image_magnifier_padding-tab-right\":\"\",\"oxi_image_magnifier_padding-tab-bottom\":\"\",\"oxi_image_magnifier_padding-tab-left\":\"\",\"oxi_image_magnifier_padding-mob-choices\":\"px\",\"oxi_image_magnifier_padding-mob-top\":\"\",\"oxi_image_magnifier_padding-mob-right\":\"\",\"oxi_image_magnifier_padding-mob-bottom\":\"\",\"oxi_image_magnifier_padding-mob-left\":\"\",\"oxi_image_magnifier_margin-lap-choices\":\"px\",\"oxi_image_magnifier_margin-lap-top\":\"10\",\"oxi_image_magnifier_margin-lap-right\":\"10\",\"oxi_image_magnifier_margin-lap-bottom\":\"10\",\"oxi_image_magnifier_margin-lap-left\":\"10\",\"oxi_image_magnifier_margin-tab-choices\":\"px\",\"oxi_image_magnifier_margin-tab-top\":\"\",\"oxi_image_magnifier_margin-tab-right\":\"\",\"oxi_image_magnifier_margin-tab-bottom\":\"\",\"oxi_image_magnifier_margin-tab-left\":\"\",\"oxi_image_magnifier_margin-mob-choices\":\"px\",\"oxi_image_magnifier_margin-mob-top\":\"\",\"oxi_image_magnifier_margin-mob-right\":\"\",\"oxi_image_magnifier_margin-mob-bottom\":\"\",\"oxi_image_magnifier_margin-mob-left\":\"\",\"oxi_image_magnifier_image_position-lap\":\"center\",\"oxi_image_magnifier_image_position-tab\":\"center\",\"oxi_image_magnifier_image_position-mob\":\"center\",\"oxi_image_magnifier_image_switcher\":\"oxi__image_width\",\"oxi_image_magnifier_image_width-lap-choices\":\"px\",\"oxi_image_magnifier_image_width-lap-size\":\"350\",\"oxi_image_magnifier_image_width-tab-choices\":\"px\",\"oxi_image_magnifier_image_width-tab-size\":\"\",\"oxi_image_magnifier_image_width-mob-choices\":\"px\",\"oxi_image_magnifier_image_width-mob-size\":\"\",\"oxi_image_comparison_handle_color\":\"#ffffff\",\"oxi_image_compersion_overlay_controler\":\"true\",\"oxi_image_comparison_before_text\":\"Before\",\"oxi_image_comparison_after_text\":\"after\",\"oxi_image_comparison_typograpy-font\":\"\",\"oxi_image_comparison_typograpy-size-lap-choices\":\"px\",\"oxi_image_comparison_typograpy-size-lap-size\":\"\",\"oxi_image_comparison_typograpy-size-tab-choices\":\"px\",\"oxi_image_comparison_typograpy-size-tab-size\":\"\",\"oxi_image_comparison_typograpy-size-mob-choices\":\"px\",\"oxi_image_comparison_typograpy-size-mob-size\":\"\",\"oxi_image_comparison_typograpy-weight\":\"\",\"oxi_image_comparison_typograpy-transform\":\"\",\"oxi_image_comparison_typograpy-style\":\"\",\"oxi_image_comparison_typograpy-decoration\":\"\",\"oxi_image_comparison_typograpy-l-height-lap-choices\":\"px\",\"oxi_image_comparison_typograpy-l-height-lap-size\":\"\",\"oxi_image_comparison_typograpy-l-height-tab-choices\":\"px\",\"oxi_image_comparison_typograpy-l-height-tab-size\":\"\",\"oxi_image_comparison_typograpy-l-height-mob-choices\":\"px\",\"oxi_image_comparison_typograpy-l-height-mob-size\":\"\",\"oxi_image_comparison_typograpy-l-spacing-lap-choices\":\"px\",\"oxi_image_comparison_typograpy-l-spacing-lap-size\":\"\",\"oxi_image_comparison_typograpy-l-spacing-tab-choices\":\"px\",\"oxi_image_comparison_typograpy-l-spacing-tab-size\":\"\",\"oxi_image_comparison_typograpy-l-spacing-mob-choices\":\"px\",\"oxi_image_comparison_typograpy-l-spacing-mob-size\":\"\",\"oxi_image_comparison_text_color\":\"#787878\",\"oxi_image_comparison_overlay_bg_color\":\"#ffffff\",\"oxi_image_comparison_overlay_text_shadow-color\":\"#ffffff\",\"oxi_image_comparison_overlay_text_shadow-blur-size\":\"0\",\"oxi_image_comparison_overlay_text_shadow-horizontal-size\":\"0\",\"oxi_image_comparison_overlay_text_shadow-vertical-size\":\"0\",\"oxi_image_comparison_overlay_button_border_radius-lap-choices\":\"px\",\"oxi_image_comparison_overlay_button_border_radius-lap-top\":\"\",\"oxi_image_comparison_overlay_button_border_radius-lap-right\":\"\",\"oxi_image_comparison_overlay_button_border_radius-lap-bottom\":\"\",\"oxi_image_comparison_overlay_button_border_radius-lap-left\":\"\",\"oxi_image_comparison_overlay_button_border_radius-tab-choices\":\"px\",\"oxi_image_comparison_overlay_button_border_radius-tab-top\":\"\",\"oxi_image_comparison_overlay_button_border_radius-tab-right\":\"\",\"oxi_image_comparison_overlay_button_border_radius-tab-bottom\":\"\",\"oxi_image_comparison_overlay_button_border_radius-tab-left\":\"\",\"oxi_image_comparison_overlay_button_border_radius-mob-choices\":\"px\",\"oxi_image_comparison_overlay_button_border_radius-mob-top\":\"\",\"oxi_image_comparison_overlay_button_border_radius-mob-right\":\"\",\"oxi_image_comparison_overlay_button_border_radius-mob-bottom\":\"\",\"oxi_image_comparison_overlay_button_border_radius-mob-left\":\"\",\"oxi_image_comparison_overlay_button_padding-lap-choices\":\"px\",\"oxi_image_comparison_overlay_button_padding-lap-top\":\"\",\"oxi_image_comparison_overlay_button_padding-lap-right\":\"\",\"oxi_image_comparison_overlay_button_padding-lap-bottom\":\"\",\"oxi_image_comparison_overlay_button_padding-lap-left\":\"\",\"oxi_image_comparison_overlay_button_padding-tab-choices\":\"px\",\"oxi_image_comparison_overlay_button_padding-tab-top\":\"\",\"oxi_image_comparison_overlay_button_padding-tab-right\":\"\",\"oxi_image_comparison_overlay_button_padding-tab-bottom\":\"\",\"oxi_image_comparison_overlay_button_padding-tab-left\":\"\",\"oxi_image_comparison_overlay_button_padding-mob-choices\":\"px\",\"oxi_image_comparison_overlay_button_padding-mob-top\":\"\",\"oxi_image_comparison_overlay_button_padding-mob-right\":\"\",\"oxi_image_comparison_overlay_button_padding-mob-bottom\":\"\",\"oxi_image_comparison_overlay_button_padding-mob-left\":\"\",\"image-hover-custom-css\":\"\",\"image-hover-preview-color\":\"#FFF\",\"image-hover-style-id\":\"16\",\"image-hover-template\":\"Comparison-1\"}","stylesheet":".oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .oxi-addons-main{border-radius: px px px px;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison{padding: px px px px;}.oxi-image-hover-wrapper-16 .oxi_addons__image_comparison_wrapper{padding: 10px 10px 10px 10px;}.oxi-image-hover-wrapper-16  .oxi-addons-main-wrapper-image-comparison{justify-content: center;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .oxi-addons-main.oxi__image_width{max-width: 350px;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-handle{border-color: #ffffff;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-up-arrow{border-bottom-color: #ffffff;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-down-arrow{border-top-color: #ffffff;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-left-arrow{border-right-color: #ffffff;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-right-arrow{border-left-color: #ffffff;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-horizontal .twentytwenty-handle::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-horizontal .twentytwenty-handle::after, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-vertical .twentytwenty-handle::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-vertical .twentytwenty-handle::after{background: #ffffff;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-before-label::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-after-label::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-before-label::before,  .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-after-label::before{color: #787878;background: #ffffff;border-radius: px px px px;padding: px px px px;}@media only screen and (min-width : 669px) and (max-width : 993px){.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .oxi-addons-main{border-radius: px px px px;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison{padding: px px px px;}.oxi-image-hover-wrapper-16 .oxi_addons__image_comparison_wrapper{padding: px px px px;}.oxi-image-hover-wrapper-16  .oxi-addons-main-wrapper-image-comparison{justify-content: center;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-before-label::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-after-label::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-before-label::before,  .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-after-label::before{border-radius: px px px px;padding: px px px px;}}@media only screen and (max-width : 668px){.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .oxi-addons-main{border-radius: px px px px;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison{padding: px px px px;}.oxi-image-hover-wrapper-16 .oxi_addons__image_comparison_wrapper{padding: px px px px;}.oxi-image-hover-wrapper-16  .oxi-addons-main-wrapper-image-comparison{justify-content: center;}.oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-before-label::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-after-label::before, .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-before-label::before,  .oxi-image-hover-wrapper-16 .oxi-addons-main-wrapper-image-comparison .twentytwenty-after-label::before{border-radius: px px px px;padding: px px px px;}}","font_family":"[]"},"child":[{"id":"19","styleid":"16","rawdata":"{\"oxi_image_comparison_image_one-select\":\"media-library\",\"oxi_image_comparison_image_one-image\":\"https:\\\/\\\/www.image-hover.oxilab.org\\\/wp-content\\\/uploads\\\/2020\\\/02\\\/pexels-photo-210019.png\",\"oxi_image_comparison_image_one-image-alt\":\"\",\"oxi_image_comparison_image_one-url\":\"https:\\\/\\\/www.shortcode-addons.com\\\/wp-content\\\/uploads\\\/2020\\\/01\\\/placeholder.png\",\"oxi_image_comparison_image_two-select\":\"media-library\",\"oxi_image_comparison_image_two-image\":\"https:\\\/\\\/www.image-hover.oxilab.org\\\/wp-content\\\/uploads\\\/2020\\\/02\\\/pexels-photo-210019-1.png\",\"oxi_image_comparison_image_two-image-alt\":\"\",\"oxi_image_comparison_image_two-url\":\"https:\\\/\\\/www.shortcode-addons.com\\\/wp-content\\\/uploads\\\/2020\\\/01\\\/placeholder.png\",\"oxi_image_comparison_body_offset-size\":\"0.5\",\"oxi_image_comparison_click\":\"false\",\"oxi_image_comparison_position\":\"true\",\"oxi_image_comparison_hover\":\"false\",\"shortcodeitemid\":\"19\"}","stylesheet":""}]}',
                ],
            ],
        ];
        $this->pre_active = [
            'display-1',
        ];
    }

}
