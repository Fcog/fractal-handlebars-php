<?php

namespace FractalHandlebars;

use Handlebars\Context;
use Handlebars\Helper;
use Handlebars\Template;

class PathHelper implements Helper {
    private $asset_path;

    public function __construct( $asset_path ) {
        $this->asset_path = $asset_path;
    }

    public function execute( Template $template, Context $context, $args, $source ) {
        return $this->asset_path . preg_replace( '/[\'\"]/', '', $args );
    }
}