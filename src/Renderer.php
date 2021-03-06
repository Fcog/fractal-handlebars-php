<?php

namespace FractalHandlebars;

use Handlebars\Context;
use Handlebars\Handlebars;
use Handlebars\Template;

/**
 * A template renderer for Handlebars templates created in the Fractal Component
 * Library site.
 */
class Renderer {

    private $engine;

	private $asset_path;

    /**
     * Renderer constructor.
     * @param string $component_lib_path The path to the component library project root.
     * @param string $asset_path The absolute path to the assets directory.
     * @param string $componentMapFile The absolute path and filename to the components map file.
     */
    public function __construct( $component_lib_path, $asset_path, $componentMapFile ) {

	    $this->asset_path = $asset_path;

        $this->engine = new Handlebars([
            'loader' => new FractalMapLoader( $component_lib_path, $componentMapFile ),
            'partials_loader' => new FractalMapLoader( $component_lib_path, $componentMapFile )
        ]);

        // add asset path helper
        $this->engine->addHelper(
        	'path',
	        function( Template $template, Context $context, $args, $source ) {
	            return $this->asset_path . preg_replace( '/[\'\"]/', '', $args );
            }
        );
    }

    /**
     * @return Handlebars The underlying Handlebars engine.
     */
    public function get_engine() {
        return $this->engine;
    }

    /**
     * @param string $handle The template handle. This is typically '@component-name', where component-name matches the name
     *                of your component file in Fractal.
     * @param array $data The data to provided to the template
     * @param bool $echo Whether to echo the template, true or return it, false
     *
     * @return string The rendered template if $echo is false
     */
    public function render( $handle, $data = [], $echo = true ) {
        $html = $this->engine->render( $handle, $data );

        if ( $echo ) {
            echo $html;
        } else {
            return $html;
        }
    }
}
