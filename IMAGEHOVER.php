<?php

namespace OXI_IMAGE_HOVER_UPLOADS;

class IMAGEHOVER {

    protected static $lfe_instance = NULL;

    public function __construct() {
        
    }

    public static function get_instance() {
        if (NULL === self::$lfe_instance)
            self::$lfe_instance = new self;

        return self::$lfe_instance;
    }

    public function public_version() {
        return '1.0.0';
    }

}
